<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avancement_physi_batiment_model extends CI_Model {
    protected $table = 'avancement_physi_batiment';

    public function add($avancement_physi_batiment) {
        $this->db->set($this->_set($avancement_physi_batiment))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avancement_physi_batiment) {
        $this->db->set($this->_set($avancement_physi_batiment))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avancement_physi_batiment) {
        return array(

            'pourcentage' => $avancement_physi_batiment['pourcentage'],
            'date'   => $avancement_physi_batiment['date'],
            'pourcentage_prevu' => $avancement_physi_batiment['pourcentage_prevu'],
            'id_contrat_prestataire' => $avancement_physi_batiment['id_contrat_prestataire']                    
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
                        ->order_by('date')
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

    public function findavancementBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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

    public function getavancementByconvention($id_convention_entete)
    {               
        $sql=" select 
                       detail.id_conv as id_conv,
                       sum(detail.avancement_physi_bat) avancement_physi_batiment,
                       sum( detail.avancement_physi_lat) as avancement_physi_latrine,
                       sum(detail.avancement_physi_mob) as avancement_physi_mobilier
               from (
               
                (
                    select 
                        conv.id as id_conv,
                         max(avanc.pourcentage) as avancement_physi_bat,
                         0 as avancement_physi_lat,
                         0 as avancement_physi_mob

                        from avancement_physi_batiment as avanc

                            inner join contrat_prestataire as cont_prest on cont_prest.id=avanc.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_prest.id_convention_entete

                        where 
                            conv.id= '".$id_convention_entete."'

                            group by conv.id
                )
                UNION
                (
                    select 
                        conv.id as id_conv,
                        0 as avancement_physi_bat,
                        max(avanc_lat.pourcentage) as avancement_physi_lat,
                        0 as avancement_physi_mob

                        from avancement_physi_latrine as avanc_lat

                            inner join contrat_prestataire as cont_prest on cont_prest.id=avanc_lat.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_prest.id_convention_entete

                        where 
                            conv.id= '".$id_convention_entete."'

                            group by conv.id
                )
                UNION
                (
                    select 
                        conv.id as id_conv,
                        0 as avancement_physi_bat,
                        0 as avancement_physi_lat,
                        max(avanc_mob.pourcentage) as avancement_physi_mob

                        from avancement_physi_mobilier as avanc_mob

                            inner join contrat_prestataire as cont_prest on cont_prest.id=avanc_mob.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_prest.id_convention_entete

                        where 
                            conv.id= '".$id_convention_entete."'

                            group by conv.id
                ) 

                )detail

                group by id_conv

            ";
            return $this->db->query($sql)->result();             
    }   

}
