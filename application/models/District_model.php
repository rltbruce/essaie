<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class District_model extends CI_Model {
    protected $table = 'district';

    public function add($district) {
        $this->db->set($this->_set($district))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $district) {
        $this->db->set($this->_set($district))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($district) {
        return array(
            'code'          =>      $district['code'],
            'nom'           =>      $district['nom'],
            'id_region'     =>      $district['id_region'],
            //'coordonnees'     =>      $district['coordonnees']                       
        );
    }
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findByregion($id_region) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_region',$id_region)
                        ->order_by('nom')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
       /* public function finddistrict_coordo() {               
        $result =  $this->db->select('*')
                        ->from('district_coordo')                        
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/


    public function update_coordo($id, $district) {
        $this->db->set($this->_set_coordo($district))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
     public function _set_coordo($district) {
        return array(
            'coordonnees'     =>      $district['coordonnees']                       
        );
    }
    public function findreportingtsmande($now, $id_district)
    {               
        $sql=" select 
                       detail.id_conv as id_conv,
                        detail.id_dist as id_dist,
                        detail.ref_convention as ref_convention,
                       sum(detail.avancement_bat) avancement_batiment,
                       sum( detail.avancement_lat) as avancement_latrine,
                       sum(detail.avancement_mob) as avancement_mobilier,
                       (sum(detail.avancement_mob)+sum( detail.avancement_lat)+sum(detail.avancement_bat))/3 as avancement_tot
               from (
               
                (
                    select 
                        conv.id as id_conv,
                        conv.ref_convention as ref_convention,
                        dist.id as id_dist,
                        0 as nom_dist,                        
                        0 as coordonnees_dist,
                         max(avanc_bat.pourcentage) as avancement_bat,
                         0 as avancement_lat,
                         0 as avancement_mob

                        from avancement_physi_batiment as avanc_bat

                            left join contrat_prestataire as cont_prest on cont_prest.id=avanc_bat.id_contrat_prestataire
                            left join convention_cisco_feffi_entete as conv on conv.id = cont_prest.id_convention_entete
                            left join convention_cisco_feffi_detail as conv_d on conv_d.id_convention_entete = conv.id
                            left join cisco as cis on cis.id = conv.id_cisco
                            left join district as dist on dist.id = cis.id_district

                        where 
                            conv.validation= 2 and DATE_FORMAT(conv_d.date_signature,'%Y')= '".$now."' and dist.id= '".$id_district."'

                            group by conv.id,dist.id
                )
                UNION
                (
                    select 
                        conv.id as id_conv,
                        0 as ref_convention,
                        dist.id as id_dist,
                        0 as nom_dist,                        
                        0 as coordonnees_dist,
                        0 as avancement_bat,
                        max(avanc_lat.pourcentage) as avancement_lat,
                        0 as avancement_mob

                        from avancement_physi_latrine as avanc_lat

                            inner join contrat_prestataire as cont_prest on cont_prest.id=avanc_lat.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_prest.id_convention_entete
                            inner join convention_cisco_feffi_detail as conv_d on conv_d.id_convention_entete = conv.id
                            inner join cisco as cis on cis.id = conv.id_cisco
                            inner join district as dist on dist.id = cis.id_district

                        where 
                            conv.validation= 2 and DATE_FORMAT(conv_d.date_signature,'%Y')= '".$now."' and dist.id= '".$id_district."'

                            group by conv.id,dist.id
                )
                UNION
                (
                    select 
                        conv.id as id_conv,
                        0 as ref_convention,
                        dist.id as id_dist,
                        0 as nom_dist,                        
                        0 as coordonnees_dist,
                        0 as avancement_bat,
                        0 as avancement_lat,
                        max(avanc_mob.pourcentage) as avancement_mob

                        from avancement_physi_mobilier as avanc_mob

                            inner join contrat_prestataire as cont_prest on cont_prest.id=avanc_mob.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_prest.id_convention_entete
                            inner join convention_cisco_feffi_detail as conv_d on conv_d.id_convention_entete = conv.id
                            inner join cisco as cis on cis.id = conv.id_cisco
                            inner join district as dist on dist.id = cis.id_district

                        where 
                            conv.validation= 2 and DATE_FORMAT(conv_d.date_signature,'%Y')= '".$now."' and dist.id= '".$id_district."'

                            group by conv.id,dist.id
                ) 

                )detail

                group by id_conv,id_dist

            ";
            return $this->db->query($sql)->result();             
    }
    public function getdistricttest($region,$district) {               
        $result =  $this->db->select('district.*')
                        ->from($this->table)
                        ->join('region','region.id=district.id_region')
                        ->where('lower(district.nom)=',$district)
                        ->where("lower(region.nom)=", $region)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
    
    public function getdistricttest2($district) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('lower(district.nom)=',$district)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }


}
