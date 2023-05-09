<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convention_cisco_feffi_entete_model extends CI_Model {
    protected $table = 'convention_cisco_feffi_entete';

    public function add($convention) {
        $this->db->set($this->_set($convention))
                            ->set('date_creation', 'NOW()', false)
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $convention) {
        $this->db->set($this->_set($convention))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($convention) {
        return array(
            'ref_convention' => $convention['ref_convention'],
            'objet' =>    $convention['objet'],
            'id_region' => $convention['id_region'],
            'id_cisco' => $convention['id_cisco'],
            'id_feffi' => $convention['id_feffi'],
            'id_site' => $convention['id_site'],
            'ref_financement'    => $convention['ref_financement'],
            //'avancement'=> $convention['avancement'],            
            'montant_total' =>    $convention['montant_total'],
            'validation'   =>$convention['validation'],
            'id_convention_ufpdaaf'   =>$convention['id_convention_ufpdaaf'],
            'type_convention'   =>$convention['type_convention'],
            'id_user'   =>$convention['id_user']                  
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
                        ->order_by('ref_convention')
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
    public function findByIdObjet($id) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getconventionByracourci($id) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getconventionvalidepresence_reliquat() { 
        
        $sql=" select 
                       convention.*,(contrat_mpe.cout_batiment+contrat_mpe.cout_latrine+contrat_mpe.cout_mobilier+contrat_moe.montant_contrat) as montant_contrat
               from convention_cisco_feffi_entete as convention
               inner join batiment_construction as bat on bat.id_convention_entete = convention.id
               inner join latrine_construction as lat on lat.id_convention_entete = convention.id               
               inner join mobilier_construction as mob on mob.id_convention_entete = convention.id               
               inner join cout_maitrise_construction as maitr on maitr.id_convention_entete = convention.id              
               inner join contrat_prestataire as contrat_mpe on contrat_mpe.id_convention_entete = convention.id             
               inner join contrat_bureau_etude as contrat_moe on contrat_moe.id_convention_entete = convention.id  
                where 
                    (bat.cout_unitaire + lat.cout_unitaire + mob.cout_unitaire + maitr.cout)>(contrat_mpe.cout_batiment+contrat_mpe.cout_latrine+contrat_mpe.cout_mobilier+contrat_moe.montant_contrat)
             group by convention.id

            ";
            return $this->db->query($sql)->result();                  
    }
    public function getconventionvalideneedavenant() { 
        
        $sql=" select 
                       convention.*,(contrat_mpe.cout_batiment+contrat_mpe.cout_latrine+contrat_mpe.cout_mobilier+contrat_moe.montant_contrat) as montant_contrat
               from convention_cisco_feffi_entete as convention
               inner join batiment_construction as bat on bat.id_convention_entete = convention.id
               inner join latrine_construction as lat on lat.id_convention_entete = convention.id               
               inner join mobilier_construction as mob on mob.id_convention_entete = convention.id               
               inner join cout_maitrise_construction as maitr on maitr.id_convention_entete = convention.id              
               inner join contrat_prestataire as contrat_mpe on contrat_mpe.id_convention_entete = convention.id             
               inner join contrat_bureau_etude as contrat_moe on contrat_moe.id_convention_entete = convention.id  
                left join avenant_convention as avenant on avenant.id_convention_entete = convention.id
                where 
                    avenant.id IS NULL and (bat.cout_unitaire + lat.cout_unitaire + mob.cout_unitaire + maitr.cout)<(contrat_mpe.cout_batiment+contrat_mpe.cout_latrine+contrat_mpe.cout_mobilier+contrat_moe.montant_contrat)
             group by convention.id

            ";
            return $this->db->query($sql)->result();                  
    }
    public function findcreerInvalideByutilisateurnow($id_utilisateur,$annee) {             //mande  
        
        $sql=" select 
                       convention.*
               from convention_cisco_feffi_entete as convention

                where 
                            convention.validation= 0 and DATE_FORMAT(convention.date_creation,'%Y')= '".$annee."' and id_user ='".$id_utilisateur."'
             

            ";
            return $this->db->query($sql)->result();                  
    }

    public function findcreerInvalidenow($annee) {             //mande  
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->where("DATE_FORMAT(date_creation,'%Y')",$annee)
                        ->where("validation",0)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function testconventionByIfvalide($id_convention_entete) { 
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id",$id_convention_entete)
                        ->where("validation!=",0)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllInvalidenow($annee) {             //mande  
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->where("DATE_FORMAT(date_creation,'%Y')",$annee)
                        ->where("validation",0)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllnow($annee) {             //mande  
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete=convention_cisco_feffi_entete.id')
                        ->where("DATE_FORMAT(convention_cisco_feffi_detail.date_signature,'%Y')",$annee)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllInvalideByecole($id_ecole) {             //mande  
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)                        
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->where("ecole.id",$id_ecole)
                        ->where("convention_cisco_feffi_entete.validation",0)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findcreerByfiltre($requete) {             //mande  
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete=convention_cisco_feffi_entete.id')                        
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zap','zap.id = ecole.id_zap')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllByfiltre($requete) {              
        $result =  $this->db->select('DISTINCT(convention_cisco_feffi_entete.id) as dd,convention_cisco_feffi_entete.*')
                        ->from($this->table)                       
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zap','zap.id = ecole.id_zap')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->where("convention_cisco_feffi_entete.validation",0)
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
    public function findconventioncreerinvalidefiltre($requete) {             //mande  
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)                        
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zap','zap.id = ecole.id_zap')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->where("convention_cisco_feffi_entete.validation",0)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllInvalideByfiltre($requete) {             //mande  
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)                        
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zap','zap.id = ecole.id_zap')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->where("convention_cisco_feffi_entete.validation",0)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllByid_ciscofiltre($id_cisco,$requete) {             //mande  
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete=convention_cisco_feffi_entete.id')
                        ->where($requete)
                        ->where("id_cisco",$id_cisco)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findcreerInvalideByutilisateurfiltre($id_utilisateur,$requete) {             //mande  
        $result =  $this->db->select('DISTINCT(convention_cisco_feffi_entete.id) as id_conv, convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zap','zap.id = ecole.id_zap')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->where("convention_cisco_feffi_entete.validation",0)
                        ->where("id_user",$id_utilisateur)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllInvalideByutilisateurfiltre($id_utilisateur,$requete) {             //mande  
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zap','zap.id = ecole.id_zap')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->where("convention_cisco_feffi_entete.validation",0)
                        ->where("id_user",$id_utilisateur)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findcreerInvalideByid_cisconow($id_cisco,$annee) {             //mande  
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->where("DATE_FORMAT(date_creation,'%Y')",$annee)
                        ->where("validation",0)
                        ->where("id_cisco",$id_cisco)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllInvalideByid_cisconow($id_cisco,$annee) { 
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->where("DATE_FORMAT(date_creation,'%Y')",$annee)
                        ->where("validation",0)
                        ->where("id_cisco",$id_cisco)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }


    public function findAllInvalideByutilisateurnow($id_utilisateur,$annee) {             //mande  
        
        $sql=" select 
                       convention.*
               from convention_cisco_feffi_entete as convention

                where 
                            convention.validation= 0 and DATE_FORMAT(convention.date_creation,'%Y')= '".$annee."' and id_user ='".$id_utilisateur."'
             

            ";
            return $this->db->query($sql)->result();                  
    }

    public function findAllInvalideByid_cisco($id_cisco) {             //mande  
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",0)
                        ->where("id_cisco",$id_cisco)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findconventionFeffiByconvention_ufpdaaf($id_convention_ufpdaaf) {       //mande        
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",2)
                        ->where("id_convention_ufpdaaf",$id_convention_ufpdaaf)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function findAllValidedaaf() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",1)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findAllValideufpByid_ciscodate($id_cisco,$date_debut,$date_fin) {               
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete= convention_cisco_feffi_entete.id')
                        ->where("validation",2)
                        ->where("id_cisco",$id_cisco)
                        ->where('convention_cisco_feffi_detail.date_signature BETWEEN "'.$date_debut.'" AND "'.$date_fin.'"')
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findconventionvalidefiltre($requete) {               
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->where("validation",2)
                        ->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zap','zap.id = ecole.id_zap')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findconventionvalidedaafBydate($requete) {               
        $result =  $this->db->select('DISTINCT(convention_cisco_feffi_entete.id) as id_con, convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zap','zap.id = ecole.id_zap')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->where("convention_cisco_feffi_entete.validation>",0)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findconventionvalideufpBydate($requete) {               
        $result =  $this->db->select('DISTINCT(convention_cisco_feffi_entete.id) as id_dist,convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        //->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zap','zap.id = ecole.id_zap')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->where("convention_cisco_feffi_entete.validation",2)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findconventionvalideufpByfiltrecisco($requete,$id_cisco) {               
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->where("convention_cisco_feffi_entete.validation",2)
                        ->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->where('convention_cisco_feffi_entete.id_cisco',$id_cisco)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findconventionvalideufpBydateutilisateur($requete,$id_utilisateur) {               
        $result =  $this->db->select('DISTINCT(convention_cisco_feffi_entete.id) as id_con,convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->where("convention_cisco_feffi_entete.validation",2)
                        //->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zap','zap.id = ecole.id_zap')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->where('convention_cisco_feffi_entete.id_user',$id_utilisateur)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findconventioninvalideufpBydateutilisateur($requete,$id_utilisateur) {               
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->where("convention_cisco_feffi_entete.validation",0)
                        ->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)
                        ->where('convention_cisco_feffi_entete.id_user',$id_utilisateur)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function finddonneeexporter($requete) {
    $this->db->select("convention_cisco_feffi_entete.*,convention_cisco_feffi_entete.id as id_conv,
        agence_acc.nom as nom_agence,ecole.description as nom_ecole, ecole.code as code_ecole,ecole.lieu as village, fokontany.nom as nom_fokontany,commune.nom as nom_commune,cisco.description as nom_cisco,region.nom as nom_region,zone_subvention.libelle as libelle_zone,acces_zone.libelle as libelle_acces,feffi.denomination as nom_feffi");

            $this->db ->select("(select batiment_construction.cout_unitaire from batiment_construction where batiment_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as cout_batiment",FALSE);

            $this->db ->select("(select convention_cisco_feffi_detail.date_signature from convention_cisco_feffi_detail where convention_cisco_feffi_detail.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as date_signature_convention",FALSE);

            $this->db ->select("(select latrine_construction.cout_unitaire from latrine_construction where latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as cout_latrine",FALSE);

            $this->db ->select("(select mobilier_construction.cout_unitaire from mobilier_construction where mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as cout_mobilier",FALSE);

            $this->db ->select("(select cout_maitrise_construction.cout from cout_maitrise_construction where cout_maitrise_construction.id_convention_entete= convention_cisco_feffi_entete.id  and convention_cisco_feffi_entete.id = id_conv) as cout_maitrise",FALSE);


            $this->db ->select("(select (cout_maitrise_construction.cout + mobilier_construction.cout_unitaire + latrine_construction.cout_unitaire + batiment_construction.cout_unitaire) from cout_maitrise_construction, mobilier_construction, latrine_construction, batiment_construction where cout_maitrise_construction.id_convention_entete= convention_cisco_feffi_entete.id and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and batiment_construction.id_convention_entete= convention_cisco_feffi_entete.id  and convention_cisco_feffi_entete.id = id_conv) as soustotaldepense",FALSE);

            $this->db ->select("(select cout_sousprojet_construction.cout from cout_sousprojet_construction where cout_sousprojet_construction.id_convention_entete= convention_cisco_feffi_entete.id  and convention_cisco_feffi_entete.id = id_conv) as cout_sousprojet",FALSE);

            $this->db ->select("(select (cout_maitrise_construction.cout + mobilier_construction.cout_unitaire + latrine_construction.cout_unitaire + batiment_construction.cout_unitaire + cout_sousprojet_construction.cout) from cout_maitrise_construction, mobilier_construction, latrine_construction, batiment_construction, cout_sousprojet_construction where cout_maitrise_construction.id_convention_entete= convention_cisco_feffi_entete.id and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and batiment_construction.id_convention_entete= convention_cisco_feffi_entete.id and cout_sousprojet_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as montant_convention",FALSE);

            $this->db ->select("(select avenant_convention.montant from avenant_convention where avenant_convention.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as cout_avenant",FALSE);

            $this->db ->select("(select transfert_daaf.montant_transfert from transfert_daaf,demande_realimentation_feffi,tranche_deblocage_feffi where transfert_daaf.id_demande_rea_feffi= demande_realimentation_feffi.id and demande_realimentation_feffi.id_convention_cife_entete= convention_cisco_feffi_entete.id and demande_realimentation_feffi.id_tranche_deblocage_feffi=tranche_deblocage_feffi.id and tranche_deblocage_feffi.code = 'tranche 1' and transfert_daaf.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as transfert_tranche1",FALSE);

            $this->db ->select("(select demande_realimentation_feffi.date_approbation from transfert_daaf,demande_realimentation_feffi,tranche_deblocage_feffi where transfert_daaf.id_demande_rea_feffi= demande_realimentation_feffi.id and demande_realimentation_feffi.id_convention_cife_entete= convention_cisco_feffi_entete.id and demande_realimentation_feffi.id_tranche_deblocage_feffi=tranche_deblocage_feffi.id and tranche_deblocage_feffi.code = 'tranche 1' and transfert_daaf.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_approbation1",FALSE);

            $this->db ->select("(select transfert_daaf.montant_transfert from transfert_daaf,demande_realimentation_feffi,tranche_deblocage_feffi where transfert_daaf.id_demande_rea_feffi= demande_realimentation_feffi.id and demande_realimentation_feffi.id_convention_cife_entete= convention_cisco_feffi_entete.id and demande_realimentation_feffi.id_tranche_deblocage_feffi=tranche_deblocage_feffi.id and tranche_deblocage_feffi.code = 'tranche 2' and transfert_daaf.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as transfert_tranche2",FALSE);

            $this->db ->select("(select demande_realimentation_feffi.date_approbation from transfert_daaf,demande_realimentation_feffi,tranche_deblocage_feffi where transfert_daaf.id_demande_rea_feffi= demande_realimentation_feffi.id and demande_realimentation_feffi.id_convention_cife_entete= convention_cisco_feffi_entete.id and demande_realimentation_feffi.id_tranche_deblocage_feffi=tranche_deblocage_feffi.id and tranche_deblocage_feffi.code = 'tranche 2' and transfert_daaf.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_approbation2",FALSE);


            $this->db ->select("(select transfert_daaf.montant_transfert from transfert_daaf,demande_realimentation_feffi,tranche_deblocage_feffi where transfert_daaf.id_demande_rea_feffi= demande_realimentation_feffi.id and demande_realimentation_feffi.id_convention_cife_entete= convention_cisco_feffi_entete.id and demande_realimentation_feffi.id_tranche_deblocage_feffi=tranche_deblocage_feffi.id and tranche_deblocage_feffi.code = 'tranche 3' and transfert_daaf.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as transfert_tranche3",FALSE);

            $this->db ->select("(select demande_realimentation_feffi.date_approbation from transfert_daaf,demande_realimentation_feffi,tranche_deblocage_feffi where transfert_daaf.id_demande_rea_feffi= demande_realimentation_feffi.id and demande_realimentation_feffi.id_convention_cife_entete= convention_cisco_feffi_entete.id and demande_realimentation_feffi.id_tranche_deblocage_feffi=tranche_deblocage_feffi.id and tranche_deblocage_feffi.code = 'tranche 3' and transfert_daaf.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_approbation3",FALSE); 


            $this->db ->select("(select transfert_daaf.montant_transfert from transfert_daaf,demande_realimentation_feffi,tranche_deblocage_feffi where transfert_daaf.id_demande_rea_feffi= demande_realimentation_feffi.id and demande_realimentation_feffi.id_convention_cife_entete= convention_cisco_feffi_entete.id and demande_realimentation_feffi.id_tranche_deblocage_feffi=tranche_deblocage_feffi.id and tranche_deblocage_feffi.code = 'tranche 4' and transfert_daaf.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as transfert_tranche4",FALSE);

            $this->db ->select("(select demande_realimentation_feffi.date_approbation from transfert_daaf,demande_realimentation_feffi,tranche_deblocage_feffi where transfert_daaf.id_demande_rea_feffi= demande_realimentation_feffi.id and demande_realimentation_feffi.id_convention_cife_entete= convention_cisco_feffi_entete.id and demande_realimentation_feffi.id_tranche_deblocage_feffi=tranche_deblocage_feffi.id and tranche_deblocage_feffi.code = 'tranche 4' and transfert_daaf.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_approbation4",FALSE); 

            //$this->db ->select("(select (sum(transfert_daaf.montant_transfert)*100)/(cout_maitrise_construction.cout + mobilier_construction.cout_unitaire + latrine_construction.cout_unitaire + batiment_construction.cout_unitaire + cout_sousprojet_construction.cout) from transfert_daaf,demande_realimentation_feffi, cout_maitrise_construction, mobilier_construction, latrine_construction, batiment_construction, cout_sousprojet_construction where transfert_daaf.id_demande_rea_feffi= demande_realimentation_feffi.id and demande_realimentation_feffi.id_convention_cife_entete= convention_cisco_feffi_entete.id and transfert_daaf.validation = '1' and cout_maitrise_construction.id_convention_entete= convention_cisco_feffi_entete.id and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and batiment_construction.id_convention_entete= convention_cisco_feffi_entete.id and cout_sousprojet_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as pourcent_decaiss_feffi",FALSE);

            $this->db ->select("(select sum(decaiss_fonct_feffi.montant) from decaiss_fonct_feffi, convention_cisco_feffi_entete where decaiss_fonct_feffi.id_convention_entete= convention_cisco_feffi_entete.id and decaiss_fonct_feffi.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as montant_decaiss_fonct_feffi",FALSE); 

//passation marches pr
            $this->db ->select("(select passation_marches_pr.date_manifestation from passation_marches_pr, convention_cisco_feffi_entete where passation_marches_pr.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_pr.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_manifestation_pr",FALSE);

            $this->db ->select("(select passation_marches_pr.date_lancement_dp from passation_marches_pr, convention_cisco_feffi_entete where passation_marches_pr.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_pr.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_lancement_dp_pr",FALSE);

            
            $this->db ->select("(select passation_marches_pr.date_remise from passation_marches_pr, convention_cisco_feffi_entete where passation_marches_pr.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_pr.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_remise_pr",FALSE);

            $this->db ->select("(select passation_marches_pr.nbr_offre_recu from passation_marches_pr, convention_cisco_feffi_entete where passation_marches_pr.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_pr.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_offre_recu_pr",FALSE);
            
            $this->db ->select("(select passation_marches_pr.date_os from passation_marches_pr, convention_cisco_feffi_entete where passation_marches_pr.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_pr.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_os_pr",FALSE); 
            
            $this->db ->select("(select partenaire_relai.nom from partenaire_relai, contrat_partenaire_relai, convention_cisco_feffi_entete where partenaire_relai.id = contrat_partenaire_relai.id_partenaire_relai and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nom_pr",FALSE);

            $this->db ->select("(select contrat_partenaire_relai.montant_contrat from contrat_partenaire_relai, convention_cisco_feffi_entete where contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as montant_contrat_pr",FALSE);
//module dpp

            $this->db ->select("(select module_dpp.date_debut_previ_form from module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_previ_form_dpp_pr",FALSE); 

            $this->db ->select("(select module_dpp.date_fin_previ_form from module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_previ_form_dpp_pr",FALSE);

            $this->db ->select("(select module_dpp.date_previ_resti from module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_previ_resti_dpp_pr",FALSE);

            $this->db ->select("(select module_dpp.date_debut_reel_form from module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_reel_form_dpp_pr",FALSE);

            $this->db ->select("(select module_dpp.date_fin_reel_form from module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_reel_form_dpp_pr",FALSE);

            $this->db ->select("(select module_dpp.date_reel_resti from module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_reel_resti_dpp_pr",FALSE);

            $this->db ->select("(select module_dpp.nbr_previ_parti from module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_parti_dpp_pr",FALSE);

            $this->db ->select("(select count(participant_dpp.id) from participant_dpp, module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_dpp.id_module_dpp=module_dpp.id and module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_parti_dpp_pr",FALSE);

            $this->db ->select("(select module_dpp.nbr_previ_fem_parti from module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_fem_parti_dpp_pr",FALSE);

            $this->db ->select("(select count(participant_dpp.id) from participant_dpp, module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_dpp.id_module_dpp=module_dpp.id and module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and participant_dpp.sexe = '2' and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_reel_fem_parti_dpp_pr",FALSE);  

            $this->db ->select("(select module_dpp.lieu_formation from module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as lieu_formation_dpp_pr",FALSE);  

            $this->db ->select("(select module_dpp.observation from module_dpp, contrat_partenaire_relai, convention_cisco_feffi_entete where module_dpp.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as observation_dpp_pr",FALSE); 
//module odc

            $this->db ->select("(select module_odc.date_debut_previ_form from module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_previ_form_odc_pr",FALSE); 

            $this->db ->select("(select module_odc.date_fin_previ_form from module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_previ_form_odc_pr",FALSE);

            $this->db ->select("(select module_odc.date_previ_resti from module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_previ_resti_odc_pr",FALSE);

            $this->db ->select("(select module_odc.date_debut_reel_form from module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_reel_form_odc_pr",FALSE);

            $this->db ->select("(select module_odc.date_fin_reel_form from module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_reel_form_odc_pr",FALSE);

            $this->db ->select("(select module_odc.date_reel_resti from module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_reel_resti_odc_pr",FALSE);

            $this->db ->select("(select module_odc.nbr_previ_parti from module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_parti_odc_pr",FALSE);

            $this->db ->select("(select count(participant_odc.id) from participant_odc, module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_odc.id_module_odc=module_odc.id and module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_parti_odc_pr",FALSE);

            $this->db ->select("(select module_odc.nbr_previ_fem_parti from module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_fem_parti_odc_pr",FALSE);

            $this->db ->select("(select count(participant_odc.id) from participant_odc, module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_odc.id_module_odc=module_odc.id and module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and participant_odc.sexe = '2' and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_reel_fem_parti_odc_pr",FALSE);  

            $this->db ->select("(select module_odc.lieu_formation from module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as lieu_formation_odc_pr",FALSE);  

            $this->db ->select("(select module_odc.observation from module_odc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_odc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as observation_odc_pr",FALSE);

//module pmc

            $this->db ->select("(select module_pmc.date_debut_previ_form from module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_previ_form_pmc_pr",FALSE); 

            $this->db ->select("(select module_pmc.date_fin_previ_form from module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_previ_form_pmc_pr",FALSE);

            $this->db ->select("(select module_pmc.date_previ_resti from module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_previ_resti_pmc_pr",FALSE);

            $this->db ->select("(select module_pmc.date_debut_reel_form from module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_reel_form_pmc_pr",FALSE);

            $this->db ->select("(select module_pmc.date_fin_reel_form from module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_reel_form_pmc_pr",FALSE);

            $this->db ->select("(select module_pmc.date_reel_resti from module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_reel_resti_pmc_pr",FALSE);

            $this->db ->select("(select module_pmc.nbr_previ_parti from module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_parti_pmc_pr",FALSE);

            $this->db ->select("(select count(participant_pmc.id) from participant_pmc, module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_pmc.id_module_pmc=module_pmc.id and module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_parti_pmc_pr",FALSE);

            $this->db ->select("(select module_pmc.nbr_previ_fem_parti from module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_fem_parti_pmc_pr",FALSE);

            $this->db ->select("(select count(participant_pmc.id) from participant_pmc, module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_pmc.id_module_pmc=module_pmc.id and module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and participant_pmc.sexe = '2' and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_reel_fem_parti_pmc_pr",FALSE); 

            $this->db ->select("(select module_pmc.lieu_formation from module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as lieu_formation_pmc_pr",FALSE);  

            $this->db ->select("(select module_pmc.observation from module_pmc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_pmc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as observation_pmc_pr",FALSE);

//module gfpc

            $this->db ->select("(select module_gfpc.date_debut_previ_form from module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_previ_form_gfpc_pr",FALSE); 

            $this->db ->select("(select module_gfpc.date_fin_previ_form from module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_previ_form_gfpc_pr",FALSE);

            $this->db ->select("(select module_gfpc.date_previ_resti from module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_previ_resti_gfpc_pr",FALSE);

            $this->db ->select("(select module_gfpc.date_debut_reel_form from module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_reel_form_gfpc_pr",FALSE);

            $this->db ->select("(select module_gfpc.date_fin_reel_form from module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_reel_form_gfpc_pr",FALSE);

            $this->db ->select("(select module_gfpc.date_reel_resti from module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_reel_resti_gfpc_pr",FALSE);

            $this->db ->select("(select module_gfpc.nbr_previ_parti from module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_parti_gfpc_pr",FALSE);

            $this->db ->select("(select count(participant_gfpc.id) from participant_gfpc, module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_gfpc.id_module_gfpc=module_gfpc.id and module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_parti_gfpc_pr",FALSE);

            $this->db ->select("(select module_gfpc.nbr_previ_fem_parti from module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_fem_parti_gfpc_pr",FALSE);

            $this->db ->select("(select count(participant_gfpc.id) from participant_gfpc, module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_gfpc.id_module_gfpc=module_gfpc.id and module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and participant_gfpc.sexe = '2' and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_reel_fem_parti_gfpc_pr",FALSE);

            $this->db ->select("(select module_gfpc.lieu_formation from module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as lieu_formation_gfpc_pr",FALSE);  

            $this->db ->select("(select module_gfpc.observation from module_gfpc, contrat_partenaire_relai, convention_cisco_feffi_entete where module_gfpc.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as observation_gfpc_pr",FALSE);

    //module sep

            $this->db ->select("(select module_sep.date_debut_previ_form from module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_previ_form_sep_pr",FALSE); 

            $this->db ->select("(select module_sep.date_fin_previ_form from module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_previ_form_sep_pr",FALSE);

            $this->db ->select("(select module_sep.date_previ_resti from module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_previ_resti_sep_pr",FALSE);

            $this->db ->select("(select module_sep.date_debut_reel_form from module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_reel_form_sep_pr",FALSE);

            $this->db ->select("(select module_sep.date_fin_reel_form from module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_reel_form_sep_pr",FALSE);

            $this->db ->select("(select module_sep.date_reel_resti from module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_reel_resti_sep_pr",FALSE);

            $this->db ->select("(select module_sep.nbr_previ_parti from module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_parti_sep_pr",FALSE);

            $this->db ->select("(select count(participant_sep.id) from participant_sep, module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_sep.id_module_sep=module_sep.id and module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_parti_sep_pr",FALSE);
 
            $this->db ->select("(select count(participant_sep.id) from participant_sep, module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_sep.id_module_sep=module_sep.id and module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and participant_sep.sexe = '2' and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_reel_fem_parti_sep_pr",FALSE); 

            $this->db ->select("(select module_sep.nbr_previ_fem_parti from module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_fem_parti_sep_pr",FALSE);

            $this->db ->select("(select module_sep.lieu_formation from module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as lieu_formation_sep_pr",FALSE);  

            $this->db ->select("(select module_sep.observation from module_sep, contrat_partenaire_relai, convention_cisco_feffi_entete where module_sep.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as observation_sep_pr",FALSE);

//module emies

            $this->db ->select("(select module_emies.date_debut_previ_form from module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_previ_form_emies_pr",FALSE); 

            $this->db ->select("(select module_emies.date_fin_previ_form from module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_previ_form_emies_pr",FALSE);

            $this->db ->select("(select module_emies.date_previ_resti from module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_previ_resti_emies_pr",FALSE);

            $this->db ->select("(select module_emies.date_debut_reel_form from module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_debut_reel_form_emies_pr",FALSE);

            $this->db ->select("(select module_emies.date_fin_reel_form from module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_fin_reel_form_emies_pr",FALSE);

            $this->db ->select("(select module_emies.date_reel_resti from module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_reel_resti_emies_pr",FALSE);

            $this->db ->select("(select module_emies.nbr_previ_parti from module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_parti_emies_pr",FALSE);

            $this->db ->select("(select count(participant_emies.id) from participant_emies, module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_emies.id_module_emies=module_emies.id and module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_parti_emies_pr",FALSE);

            $this->db ->select("(select module_emies.nbr_previ_fem_parti from module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_previ_fem_parti_emies_pr",FALSE);

            $this->db ->select("(select count(participant_emies.id) from participant_emies, module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where participant_emies.id_module_emies=module_emies.id and module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and participant_emies.sexe = '2' and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_reel_fem_parti_emies_pr",FALSE);  

            $this->db ->select("(select module_emies.lieu_formation from module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as lieu_formation_emies_pr",FALSE);  

            $this->db ->select("(select module_emies.observation from module_emies, contrat_partenaire_relai, convention_cisco_feffi_entete where module_emies.id_contrat_partenaire_relai= contrat_partenaire_relai.id and contrat_partenaire_relai.id_convention_entete= convention_cisco_feffi_entete.id and contrat_partenaire_relai.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as observation_emies_pr",FALSE);

//passation marches moe

            $this->db ->select("(select passation_marches_be.date_shortlist from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_shortlist_moe",FALSE);

            $this->db ->select("(select passation_marches_be.date_manifestation from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_manifestation_moe",FALSE);
            
            $this->db ->select("(select passation_marches_be.date_lancement_dp from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_lancement_dp_moe",FALSE);
            
            $this->db ->select("(select passation_marches_be.date_remise from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_remise_moe",FALSE);
            
            $this->db ->select("(select passation_marches_be.nbr_offre_recu from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_offre_recu_moe",FALSE);
            
            $this->db ->select("(select passation_marches_be.date_rapport_evaluation from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_rapport_evaluation_moe",FALSE);
            
            $this->db ->select("(select passation_marches_be.date_demande_ano_dpfi from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_demande_ano_dpfi_moe",FALSE);
            
            $this->db ->select("(select passation_marches_be.date_ano_dpfi from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_ano_dpfi_moe",FALSE);
            
            $this->db ->select("(select passation_marches_be.notification_intention from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as notification_intention_moe",FALSE);
            
            $this->db ->select("(select passation_marches_be.date_notification_attribution from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_notification_attribution_moe",FALSE);

           // $this->db ->select("(select passation_marches_be.date_signature_contrat from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_signature_contrat_moe",FALSE);
            
            $this->db ->select("(select passation_marches_be.date_os from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_os_moe",FALSE);

            $this->db ->select("(select bureau_etude.nom from bureau_etude, contrat_bureau_etude, convention_cisco_feffi_entete where bureau_etude.id=contrat_bureau_etude.id_bureau_etude and contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and contrat_bureau_etude.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nom_bureau_etude_moe",FALSE);

            $this->db ->select("(select passation_marches_be.statut from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as statut_moe",FALSE);

            $this->db ->select("(select passation_marches_be.observation from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as observation_moe",FALSE);
//paiement moe

            $this->db ->select("(select sum(facture_moe_detail.montant_periode) from facture_moe_detail,facture_moe_entete, contrat_bureau_etude, convention_cisco_feffi_entete where facture_moe_detail.id_facture_moe_entete= facture_moe_entete.id and facture_moe_entete.id_contrat_bureau_etude=contrat_bureau_etude.id and contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and facture_moe_entete.validation = '2' and convention_cisco_feffi_entete.id = id_conv) as montant_paiement_moe",FALSE);

            /*$this->db ->select("(select sum(demande_debut_travaux_moe.montant) from demande_debut_travaux_moe, contrat_bureau_etude, convention_cisco_feffi_entete where  demande_debut_travaux_moe.id_contrat_bureau_etude=contrat_bureau_etude.id and contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and demande_debut_travaux_moe.validation = '4' and convention_cisco_feffi_entete.id = id_conv) as montant_paiement_debut_moe",FALSE);

            $this->db ->select("(select sum(demande_batiment_moe.montant) from demande_batiment_moe, contrat_bureau_etude, convention_cisco_feffi_entete where demande_batiment_moe.id_contrat_bureau_etude=contrat_bureau_etude.id and contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and demande_batiment_moe.validation = '4' and convention_cisco_feffi_entete.id = id_conv) as montant_paiement_batiment_moe",FALSE);

            $this->db ->select("(select sum(demande_latrine_moe.montant) from demande_latrine_moe, contrat_bureau_etude, convention_cisco_feffi_entete where demande_latrine_moe.id_contrat_bureau_etude=contrat_bureau_etude.id and contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and demande_latrine_moe.validation = '4' and convention_cisco_feffi_entete.id = id_conv) as montant_paiement_latrine_moe",FALSE);


            $this->db ->select("(select sum(demande_fin_travaux_moe.montant) from demande_fin_travaux_moe, contrat_bureau_etude, convention_cisco_feffi_entete where  demande_fin_travaux_moe.id_contrat_bureau_etude=contrat_bureau_etude.id and contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and demande_fin_travaux_moe.validation = '4' and convention_cisco_feffi_entete.id = id_conv) as montant_paiement_fin_moe",FALSE);*/


//contrat_moe

            $this->db ->select("(select contrat_bureau_etude.montant_contrat from contrat_bureau_etude, convention_cisco_feffi_entete where contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and contrat_bureau_etude.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as montant_contrat_moe",FALSE);

            $this->db ->select("(select passation_marches_be.date_signature_contrat from passation_marches_be, convention_cisco_feffi_entete where passation_marches_be.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches_be.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_signature_contrat_moe",FALSE);

            $this->db ->select("(select avenant_bureau_etude.montant from avenant_bureau_etude, contrat_bureau_etude, convention_cisco_feffi_entete where avenant_bureau_etude.id_contrat_bureau_etude = contrat_bureau_etude.id and  contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and avenant_bureau_etude.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as montant_avenant_moe",FALSE);
//prestation be

            $this->db ->select("(select memoire_technique.date_livraison from memoire_technique, contrat_bureau_etude, convention_cisco_feffi_entete where memoire_technique.id_contrat_bureau_etude = contrat_bureau_etude.id and  contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and memoire_technique.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_livraison_mt",FALSE);

            $this->db ->select("(select memoire_technique.date_approbation from memoire_technique, contrat_bureau_etude, convention_cisco_feffi_entete where memoire_technique.id_contrat_bureau_etude = contrat_bureau_etude.id and  contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and memoire_technique.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_approbation_mt",FALSE);

            $this->db ->select("(select appel_offre.date_livraison from appel_offre, contrat_bureau_etude, convention_cisco_feffi_entete where appel_offre.id_contrat_bureau_etude = contrat_bureau_etude.id and  contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and appel_offre.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_livraison_dao",FALSE);

            $this->db ->select("(select appel_offre.date_approbation from appel_offre, contrat_bureau_etude, convention_cisco_feffi_entete where appel_offre.id_contrat_bureau_etude = contrat_bureau_etude.id and  contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and appel_offre.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_approbation_dao",FALSE);

            $this->db ->select("(select manuel_gestion.date_livraison from manuel_gestion, contrat_bureau_etude, convention_cisco_feffi_entete where manuel_gestion.id_contrat_bureau_etude = contrat_bureau_etude.id and  contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and manuel_gestion.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_livraison_mg",FALSE);

            $this->db ->select("(select rapport_mensuel.date_livraison from rapport_mensuel, contrat_bureau_etude, convention_cisco_feffi_entete where rapport_mensuel.id_contrat_bureau_etude = contrat_bureau_etude.id and  contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and rapport_mensuel.validation = '1' and convention_cisco_feffi_entete.id = id_conv and rapport_mensuel.id = (select min(rp.id)+3 from rapport_mensuel as rp ,contrat_bureau_etude as contr, convention_cisco_feffi_entete as conv where rp.id_contrat_bureau_etude = contr.id and  contr.id_convention_entete= conv.id and rp.validation = '1' and conv.id = id_conv)) as date_livraison_rp4",FALSE);

            $this->db ->select("(select rapport_mensuel.date_livraison from rapport_mensuel, contrat_bureau_etude, convention_cisco_feffi_entete where rapport_mensuel.id_contrat_bureau_etude = contrat_bureau_etude.id and  contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and rapport_mensuel.validation = '1' and convention_cisco_feffi_entete.id = id_conv and rapport_mensuel.id = (select min(rp.id)+2 from rapport_mensuel as rp ,contrat_bureau_etude as contr, convention_cisco_feffi_entete as conv where rp.id_contrat_bureau_etude = contr.id and  contr.id_convention_entete= conv.id and rp.validation = '1' and conv.id = id_conv)) as date_livraison_rp3",FALSE);

            $this->db ->select("(select rapport_mensuel.date_livraison from rapport_mensuel, contrat_bureau_etude, convention_cisco_feffi_entete where rapport_mensuel.id_contrat_bureau_etude = contrat_bureau_etude.id and  contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and rapport_mensuel.validation = '1' and convention_cisco_feffi_entete.id = id_conv and rapport_mensuel.id = (select min(rp.id)+1 from rapport_mensuel as rp ,contrat_bureau_etude as contr, convention_cisco_feffi_entete as conv where rp.id_contrat_bureau_etude = contr.id and  contr.id_convention_entete= conv.id and rp.validation = '1' and conv.id = id_conv)) as date_livraison_rp2",FALSE);

            $this->db ->select("(select rapport_mensuel.date_livraison from rapport_mensuel, contrat_bureau_etude, convention_cisco_feffi_entete where rapport_mensuel.id_contrat_bureau_etude = contrat_bureau_etude.id and  contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and rapport_mensuel.validation = '1' and convention_cisco_feffi_entete.id = id_conv and rapport_mensuel.id = (select min(rp.id) from rapport_mensuel as rp ,contrat_bureau_etude as contr, convention_cisco_feffi_entete as conv where rp.id_contrat_bureau_etude = contr.id and  contr.id_convention_entete= conv.id and rp.validation = '1' and conv.id = id_conv)) as date_livraison_rp1",FALSE);
          

            $this->db ->select("(select police_assurance.date_expiration from police_assurance, contrat_bureau_etude, convention_cisco_feffi_entete where police_assurance.id_contrat_bureau_etude = contrat_bureau_etude.id and  contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and police_assurance.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_expiration_poli_moe",FALSE);

//passation pme

            $this->db ->select("(select passation_marches.date_lancement from passation_marches, convention_cisco_feffi_entete where passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_lancement_pme",FALSE);

            $this->db ->select("(select passation_marches.date_remise from passation_marches, convention_cisco_feffi_entete where passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_remise_pme",FALSE);

            $this->db ->select("(select passation_marches.montant_moin_chere from passation_marches, convention_cisco_feffi_entete where passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as montant_moin_chere_pme",FALSE);

            $this->db ->select("(select passation_marches.date_rapport_evaluation from passation_marches, convention_cisco_feffi_entete where passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_rapport_evaluation_pme",FALSE);

            $this->db ->select("(select passation_marches.date_demande_ano_dpfi from passation_marches, convention_cisco_feffi_entete where passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_demande_ano_dpfi_pme",FALSE);

            $this->db ->select("(select passation_marches.date_ano_dpfi from passation_marches, convention_cisco_feffi_entete where passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_ano_dpfi_pme",FALSE);

            $this->db ->select("(select passation_marches.notification_intention from passation_marches, convention_cisco_feffi_entete where passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as notification_intention_pme",FALSE);

            $this->db ->select("(select passation_marches.date_notification_attribution from passation_marches, convention_cisco_feffi_entete where passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_notification_attribution_pme",FALSE);
            $this->db ->select("(select passation_marches.date_signature_contrat from passation_marches, convention_cisco_feffi_entete where passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_signature_pme",FALSE);

            $this->db ->select("(select passation_marches.date_os from passation_marches, convention_cisco_feffi_entete where passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_os_pme",FALSE);

            $this->db ->select("(select passation_marches.observation from passation_marches, convention_cisco_feffi_entete where passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as observation_passation_pme",FALSE);

            $this->db ->select("(select count(mpe_soumissionaire.id) from mpe_soumissionaire, passation_marches, convention_cisco_feffi_entete where mpe_soumissionaire.id_passation_marches=passation_marches.id and passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_mpe_soumissionaire_pme",FALSE);
            $this->db ->select("(select GROUP_CONCAT(prestataire.nom SEPARATOR ',') from prestataire,mpe_soumissionaire, passation_marches, convention_cisco_feffi_entete where mpe_soumissionaire.id_prestataire=prestataire.id and mpe_soumissionaire.id_passation_marches=passation_marches.id and passation_marches.id_convention_entete= convention_cisco_feffi_entete.id and passation_marches.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as liste_mpe_soumissionaire",FALSE);

//contrat mpe

            $this->db ->select("(select prestataire.nom from prestataire, contrat_prestataire, convention_cisco_feffi_entete where prestataire.id=contrat_prestataire.id_prestataire and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and contrat_prestataire.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nom_prestataire",FALSE);

            $this->db ->select("(select contrat_prestataire.cout_batiment from contrat_prestataire, convention_cisco_feffi_entete where contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and contrat_prestataire.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as cout_batiment_pme",FALSE);

            $this->db ->select("(select contrat_prestataire.cout_latrine from contrat_prestataire, convention_cisco_feffi_entete where contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and contrat_prestataire.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as cout_latrine_pme",FALSE);

            $this->db ->select("(select contrat_prestataire.cout_mobilier from contrat_prestataire, convention_cisco_feffi_entete where contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and contrat_prestataire.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as cout_mobilier_pme",FALSE);

            $this->db ->select("(select avenant_prestataire.cout_batiment from avenant_prestataire, contrat_prestataire, convention_cisco_feffi_entete where avenant_prestataire.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and contrat_prestataire.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as cout_batiment_avenant_mpe",FALSE);

            $this->db ->select("(select avenant_prestataire.cout_latrine from avenant_prestataire, contrat_prestataire, convention_cisco_feffi_entete where avenant_prestataire.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and contrat_prestataire.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as cout_latrine_avenant_mpe",FALSE);

            $this->db ->select("(select avenant_prestataire.cout_mobilier from avenant_prestataire, contrat_prestataire, convention_cisco_feffi_entete where avenant_prestataire.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and contrat_prestataire.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as cout_mobilier_avenant_mpe",FALSE);

            $this->db ->select("(select etape_sousprojet.libelle from etape_sousprojet,phase_sous_projet,delai_travaux,contrat_prestataire, convention_cisco_feffi_entete where etape_sousprojet.id = phase_sous_projet.id_etape_sousprojet and phase_sous_projet.id_delai_travaux=delai_travaux.id and delai_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and delai_travaux.validation = '1' and convention_cisco_feffi_entete.id = id_conv and phase_sous_projet.id=(select max(pha.id) from phase_sous_projet as pha,delai_travaux as delai,contrat_prestataire as contra, convention_cisco_feffi_entete as conve where pha.id_delai_travaux=delai.id and delai.id_contrat_prestataire=contra.id and contra.id_convention_entete= conve.id and delai.validation = '1' and conve.id = id_conv)) as phase_sousprojet_mpe",FALSE);
//delai _travaux

            $this->db ->select("(select delai_travaux.date_prev_debu_travau from delai_travaux,contrat_prestataire, convention_cisco_feffi_entete where delai_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and delai_travaux.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_prev_debu_travau_mpe",FALSE);

            $this->db ->select("(select delai_travaux.date_reel_debu_travau from delai_travaux,contrat_prestataire, convention_cisco_feffi_entete where delai_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and delai_travaux.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_reel_debu_travau_mpe",FALSE);

            $this->db ->select("(select delai_travaux.delai_execution from delai_travaux,contrat_prestataire, convention_cisco_feffi_entete where delai_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and delai_travaux.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as delai_execution_mpe",FALSE);

            $this->db ->select("(select delai_travaux.date_expiration_police from delai_travaux,contrat_prestataire, convention_cisco_feffi_entete where delai_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and delai_travaux.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_expiration_police_mpe",FALSE);

//RECEPTION
            $this->db ->select("(select reception_mpe.date_previ_recep_tech from reception_mpe,contrat_prestataire, convention_cisco_feffi_entete where reception_mpe.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and reception_mpe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_previ_recep_tech_mpe",FALSE);

            $this->db ->select("(select reception_mpe.date_reel_tech from reception_mpe,contrat_prestataire, convention_cisco_feffi_entete where reception_mpe.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and reception_mpe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_reel_tech_mpe",FALSE);

            $this->db ->select("(select reception_mpe.date_leve_recep_tech from reception_mpe,contrat_prestataire, convention_cisco_feffi_entete where reception_mpe.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and reception_mpe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_leve_recep_tech_mpe",FALSE);

            $this->db ->select("(select reception_mpe.date_previ_recep_prov from reception_mpe,contrat_prestataire, convention_cisco_feffi_entete where reception_mpe.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and reception_mpe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_previ_recep_prov_mpe",FALSE);

            $this->db ->select("(select reception_mpe.date_reel_recep_prov from reception_mpe,contrat_prestataire, convention_cisco_feffi_entete where reception_mpe.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and reception_mpe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_reel_recep_prov_mpe",FALSE);

            $this->db ->select("(select reception_mpe.date_previ_leve from reception_mpe,contrat_prestataire, convention_cisco_feffi_entete where reception_mpe.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and reception_mpe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_previ_leve_mpe",FALSE);

            $this->db ->select("(select reception_mpe.date_reel_lev_ava_rd from reception_mpe,contrat_prestataire, convention_cisco_feffi_entete where reception_mpe.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and reception_mpe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_reel_lev_ava_rd_mpe",FALSE);

            $this->db ->select("(select reception_mpe.date_previ_recep_defi from reception_mpe,contrat_prestataire, convention_cisco_feffi_entete where reception_mpe.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and reception_mpe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_previ_recep_defi_mpe",FALSE);

            $this->db ->select("(select reception_mpe.date_reel_recep_defi from reception_mpe,contrat_prestataire, convention_cisco_feffi_entete where reception_mpe.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and reception_mpe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as date_reel_recep_defi_mpe",FALSE);

            $this->db ->select("(select reception_mpe.observation from reception_mpe,contrat_prestataire, convention_cisco_feffi_entete where reception_mpe.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and reception_mpe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as observation_recep_mpe",FALSE);

           // $this->db ->select("(select max(avancement_physi_batiment.pourcentage) from avancement_physi_batiment,contrat_prestataire, convention_cisco_feffi_entete where  avancement_physi_batiment.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as avancement_batiment_mpe",FALSE);

           // $this->db ->select("(select max(avancement_physi_latrine.pourcentage) from avancement_physi_latrine,contrat_prestataire, convention_cisco_feffi_entete where  avancement_physi_latrine.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as avancement_latrine_mpe",FALSE);

           //$this->db ->select("(select max(avancement_physi_mobilier.pourcentage) from avancement_physi_mobilier,contrat_prestataire, convention_cisco_feffi_entete where  avancement_physi_mobilier.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as avancement_mobilier_mpe",FALSE);
//avancement physique

        $this->db ->select("(
            select sum(detail_bat_travaux.periode) from pv_consta_detail_bat_travaux as detail_bat_travaux
                inner join pv_consta_entete_travaux as entete_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                
                where 
                entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                    inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                    inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                    inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                    where convent.id=id_conv and fac_mpe.validation=2)) as periode_bat_avance_phy",FALSE);
            $this->db ->select("(
                select sum(detail_lat_travaux.periode) from pv_consta_detail_lat_travaux as detail_lat_travaux
                    inner join pv_consta_entete_travaux as entete_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                    
                    where 
                        entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                            inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                            inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                            where convent.id=id_conv and fac_mpe.validation=2)) as periode_lat_avance_phy",FALSE);  
            $this->db ->select("(
                select sum(detail_mob_travaux.periode) from pv_consta_detail_mob_travaux as detail_mob_travaux
                    inner join pv_consta_entete_travaux as entete_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                    
                    where 
                        entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                            inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                            inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                            where convent.id=id_conv and fac_mpe.validation=2)) as periode_mob_avance_phy",FALSE);
            
            $this->db ->select("(
                select sum(detail_bat_travaux.periode) from pv_consta_detail_bat_travaux as detail_bat_travaux
                    inner join pv_consta_entete_travaux as entete_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                    inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                    inner join convention_cisco_feffi_entete as convention on convention.id= contrat_mpe.id_convention_entete
                    inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                    where 
                        convention.id=id_conv and fact_mpe.validation=2 and
                        entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                            inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                            inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                            where convent.id=id_conv and fac_mpe.validation=2)) as anterieur_bat_avance_phy",FALSE);
            $this->db ->select("(
                select sum(detail_lat_travaux.periode) from pv_consta_detail_lat_travaux as detail_lat_travaux
                        inner join pv_consta_entete_travaux as entete_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                        inner join convention_cisco_feffi_entete as convention on convention.id= contrat_mpe.id_convention_entete
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                            convention.id=id_conv and fact_mpe.validation=2 and
                            entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                                inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                                inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                                where convent.id=id_conv and fac_mpe.validation=2)) as anterieur_lat_avance_phy",FALSE);
            $this->db ->select("(
                select sum(detail_mob_travaux.periode) from pv_consta_detail_mob_travaux as detail_mob_travaux
                    inner join pv_consta_entete_travaux as entete_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                    inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                    inner join convention_cisco_feffi_entete as convention on convention.id= contrat_mpe.id_convention_entete
                    inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                    where 
                        convention.id=id_conv and fact_mpe.validation=2 and
                        entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                            inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                            inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                            where convent.id=id_conv and fac_mpe.validation=2)) as anterieur_mob_avance_phy",FALSE);

        $this->db ->select("(
            select contrat_mpe.cout_batiment from contrat_prestataire as contrat_mpe
                where contrat_mpe.id_convention_entete = id_conv ) as cout_batiment_avance_phy",FALSE);

        $this->db ->select("(
            select contrat_mpe.cout_latrine from contrat_prestataire as contrat_mpe
                where contrat_mpe.id_convention_entete = id_conv ) as cout_latrine_avance_phy",FALSE);

        $this->db ->select("(
            select contrat_mpe.cout_mobilier from contrat_prestataire as contrat_mpe
                where contrat_mpe.id_convention_entete = id_conv ) as cout_mobilier_avance_phy",FALSE);
        $this->db ->select("(
            select contrat_mpe.cout_mobilier + contrat_mpe.cout_latrine + contrat_mpe.cout_batiment  from contrat_prestataire as contrat_mpe
                where contrat_mpe.id_convention_entete = id_conv ) as montant_contrat_avance_phy",FALSE);

//PAIEMENT MPE talou fa ts net fotsiny
          /*  $this->db ->select("(select facture_mpe.montant_ttc from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='1') as montant_paiement_mpe1",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='1') as date_approbation_mpe1",FALSE);

            $this->db ->select("(select facture_mpe.montant_ttc from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='2') as montant_paiement_mpe2",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='2') as date_approbation_mpe2",FALSE);

            $this->db ->select("(select facture_mpe.montant_ttc from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='3') as montant_paiement_mpe3",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='3') as date_approbation_mpe3",FALSE);

            $this->db ->select("(select facture_mpe.montant_ttc from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='4') as montant_paiement_mpe4",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='4') as date_approbation_mpe4",FALSE);

            $this->db ->select("(select facture_mpe.montant_ttc from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='5') as montant_paiement_mpe5",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='5') as date_approbation_mpe5",FALSE);

            $this->db ->select("(select facture_mpe.montant_ttc from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='6') as montant_paiement_mpe6",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='6') as date_approbation_mpe6",FALSE);

            $this->db ->select("(select facture_mpe.montant_ttc from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='7') as montant_paiement_mpe7",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='7') as date_approbation_mpe7",FALSE);

            $this->db ->select("(select facture_mpe.montant_ttc from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='8') as montant_paiement_mpe8",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='8') as date_approbation_mpe8",FALSE);

            $this->db ->select("(select facture_mpe.montant_ttc from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='9') as montant_paiement_mpe9",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='9') as date_approbation_mpe9",FALSE);

            $this->db ->select("(select facture_mpe.montant_ttc from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='10') as montant_paiement_mpe10",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='10') as date_approbation_mpe10",FALSE);

            $this->db ->select("(select facture_mpe.montant_ttc from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='11') as montant_paiement_mpe11",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,attachement_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='11') as date_approbation_mpe11",FALSE);

            
            $this->db ->select("(select attachement_travaux.total_anterieur + ((attachement_travaux.total_anterieur*20)/100) from attachement_travaux,facture_mpe, contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.id=(select max(fact_mpe.id) from facture_mpe as fact_mpe,attachement_travaux as atta_tra, contrat_prestataire as contra_m, convention_cisco_feffi_entete as conve_m where fact_mpe.id_attachement_travaux=atta_tra.id and atta_tra.id_contrat_prestataire=contra_m.id and contra_m.id_convention_entete= conve_m.id and fact_mpe.validation = '4' and conve_m.id = id_conv )) as anterieur_mpe",FALSE);

                $this->db ->select("(select attachement_travaux.total_cumul + ((attachement_travaux.total_cumul*20)/100) from attachement_travaux,facture_mpe, contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.id=(select max(fact_mpe.id) from facture_mpe as fact_mpe,attachement_travaux as atta_tra, contrat_prestataire as contra_m, convention_cisco_feffi_entete as conve_m where fact_mpe.id_attachement_travaux=atta_tra.id and atta_tra.id_contrat_prestataire=contra_m.id and contra_m.id_convention_entete= conve_m.id and fact_mpe.validation = '4' and conve_m.id = id_conv )) as cumul_mpe",FALSE);

                $this->db ->select("(select attachement_travaux.total_periode + ((attachement_travaux.total_periode*20)/100) from attachement_travaux,facture_mpe, contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_attachement_travaux=attachement_travaux.id and attachement_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.id=(select max(fact_mpe.id) from facture_mpe as fact_mpe,attachement_travaux as atta_tra, contrat_prestataire as contra_m, convention_cisco_feffi_entete as conve_m where fact_mpe.id_attachement_travaux=atta_tra.id and atta_tra.id_contrat_prestataire=contra_m.id and contra_m.id_convention_entete= conve_m.id and fact_mpe.validation = '4' and conve_m.id = id_conv )) as periode_mpe",FALSE);*/

//PAIEMENT MPE
            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='1') as montant_paiement_mpe1",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='1') as date_approbation_mpe1",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='2') as montant_paiement_mpe2",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='2') as date_approbation_mpe2",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='3') as montant_paiement_mpe3",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='3') as date_approbation_mpe3",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='4') as montant_paiement_mpe4",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='4') as date_approbation_mpe4",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='5') as montant_paiement_mpe5",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='5') as date_approbation_mpe5",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='6') as montant_paiement_mpe6",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='6') as date_approbation_mpe6",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='7') as montant_paiement_mpe7",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='7') as date_approbation_mpe7",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='8') as montant_paiement_mpe8",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='8') as date_approbation_mpe8",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='9') as montant_paiement_mpe9",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='9') as date_approbation_mpe9",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='10') as montant_paiement_mpe10",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='10') as date_approbation_mpe10",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='11') as montant_paiement_mpe11",FALSE);

            $this->db ->select("(select facture_mpe.date_approbation from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='11') as date_approbation_mpe11",FALSE);

            
            $this->db ->select("(select sum(facture_mpe.net_payer) from pv_consta_entete_travaux,facture_mpe, contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and 
                                        facture_mpe.id<(select max(fact_mpe.id) from facture_mpe as fact_mpe,pv_consta_entete_travaux as atta_tra, contrat_prestataire as contra_m, convention_cisco_feffi_entete as conve_m where fact_mpe.id_pv_consta_entete_travaux=atta_tra.id and atta_tra.id_contrat_prestataire=contra_m.id and contra_m.id_convention_entete= conve_m.id and fact_mpe.validation = '2' and conve_m.id = id_conv)) as anterieur_mpe",FALSE);

                $this->db ->select("(select sum(facture_mpe.net_payer) from pv_consta_entete_travaux,facture_mpe, contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv) as cumul_mpe",FALSE);

                $this->db ->select("(select facture_mpe.net_payer from pv_consta_entete_travaux,facture_mpe, contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.id=(select max(fact_mpe.id) from facture_mpe as fact_mpe,pv_consta_entete_travaux as atta_tra, contrat_prestataire as contra_m, convention_cisco_feffi_entete as conve_m where fact_mpe.id_pv_consta_entete_travaux=atta_tra.id and atta_tra.id_contrat_prestataire=contra_m.id and contra_m.id_convention_entete= conve_m.id and fact_mpe.validation = '2' and conve_m.id = id_conv )) as periode_mpe",FALSE);

                $this->db ->select("(select avance_demarrage.net_payer from avance_demarrage,contrat_prestataire where avance_demarrage.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and avance_demarrage.validation = '2' and convention_cisco_feffi_entete.id = id_conv) as montant_paiement_avance_mpe",FALSE);

                $this->db ->select("(select avance_demarrage.date_approbation from avance_demarrage,contrat_prestataire where avance_demarrage.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and avance_demarrage.validation = '2' and convention_cisco_feffi_entete.id = id_conv) as date_approbation_avance_mpe",FALSE);


//transfert reliquat

            $this->db ->select("(select transfert_reliquat.montant from transfert_reliquat, convention_cisco_feffi_entete where transfert_reliquat.id_convention_entete= convention_cisco_feffi_entete.id and transfert_reliquat.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as montant_transfert_reliquat",FALSE);

            $this->db ->select("(select transfert_reliquat.objet_utilisation from transfert_reliquat, convention_cisco_feffi_entete where transfert_reliquat.id_convention_entete= convention_cisco_feffi_entete.id and transfert_reliquat.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as objet_utilisation_reliquat",FALSE);

            $this->db ->select("(select transfert_reliquat.situation_utilisation from transfert_reliquat, convention_cisco_feffi_entete where transfert_reliquat.id_convention_entete= convention_cisco_feffi_entete.id and transfert_reliquat.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as situation_utilisation_reliquat",FALSE);

            $this->db ->select("(select transfert_reliquat.observation from transfert_reliquat, convention_cisco_feffi_entete where transfert_reliquat.id_convention_entete= convention_cisco_feffi_entete.id and transfert_reliquat.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as observation_reliquat",FALSE);

//indicateur

            $this->db ->select("(select indicateur.nbr_salle_const from indicateur, convention_cisco_feffi_entete where indicateur.id_convention_entete= convention_cisco_feffi_entete.id and indicateur.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_salle_const_indicateur",FALSE);

            $this->db ->select("(select convention_cisco_feffi_detail.prev_beneficiaire from convention_cisco_feffi_detail where convention_cisco_feffi_detail.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_beneficiaire",FALSE);

            $this->db ->select("(select indicateur.nbr_beneficiaire from indicateur, convention_cisco_feffi_entete where indicateur.id_convention_entete= convention_cisco_feffi_entete.id and indicateur.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_beneficiaire_indicateur",FALSE);

            $this->db ->select("(select convention_cisco_feffi_detail.prev_nbr_ecole from convention_cisco_feffi_detail where convention_cisco_feffi_detail.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_ecole",FALSE);
            
            $this->db ->select("(select indicateur.nbr_ecole from indicateur, convention_cisco_feffi_entete where indicateur.id_convention_entete= convention_cisco_feffi_entete.id and indicateur.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_ecole_indicateur",FALSE);
            
            $this->db ->select("(select indicateur.nbr_box from indicateur, convention_cisco_feffi_entete where indicateur.id_convention_entete= convention_cisco_feffi_entete.id and indicateur.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_box_indicateur",FALSE);
            
            $this->db ->select("(select indicateur.nbr_point_eau from indicateur, convention_cisco_feffi_entete where indicateur.id_convention_entete= convention_cisco_feffi_entete.id and indicateur.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_point_eau_indicateur",FALSE);
            
            $this->db ->select("(select indicateur.nbr_banc from indicateur, convention_cisco_feffi_entete where indicateur.id_convention_entete= convention_cisco_feffi_entete.id and indicateur.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_banc_indicateur",FALSE);
            
            $this->db ->select("(select indicateur.nbr_table_maitre from indicateur, convention_cisco_feffi_entete where indicateur.id_convention_entete= convention_cisco_feffi_entete.id and indicateur.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_table_maitre_indicateur",FALSE);
            
            $this->db ->select("(select indicateur.nbr_chaise from indicateur, convention_cisco_feffi_entete where indicateur.id_convention_entete= convention_cisco_feffi_entete.id and indicateur.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as nbr_chaise_indicateur",FALSE);
            
            $this->db ->select("(select indicateur.observation from indicateur, convention_cisco_feffi_entete where indicateur.id_convention_entete= convention_cisco_feffi_entete.id and indicateur.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as observation_indicateur",FALSE);

            $this->db ->select("(select type_batiment.nbr_salle from type_batiment,batiment_construction where type_batiment.id = batiment_construction.id_type_batiment and batiment_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_salle",FALSE);

            $this->db ->select("(select type_latrine.nbr_box_latrine from type_latrine,latrine_construction where type_latrine.id = latrine_construction.id_type_latrine and latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_box_latrine",FALSE);

            $this->db ->select("(select type_latrine.nbr_point_eau from type_latrine,latrine_construction where type_latrine.id = latrine_construction.id_type_latrine and latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_point_eau",FALSE);

            $this->db ->select("(select type_mobilier.nbr_table_banc from type_mobilier,mobilier_construction where type_mobilier.id = mobilier_construction.id_type_mobilier and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_table_banc",FALSE);

            $this->db ->select("(select type_mobilier.nbr_table_maitre from type_mobilier,mobilier_construction where type_mobilier.id = mobilier_construction.id_type_mobilier and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_table_maitre",FALSE);

            $this->db ->select("(select type_mobilier.nbr_chaise_maitre from type_mobilier,mobilier_construction where type_mobilier.id = mobilier_construction.id_type_mobilier and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_chaise_maitre",FALSE);






    $result =  $this->db->from('convention_cisco_feffi_entete')
                        
                        ->where("convention_cisco_feffi_entete.validation",2)
                        ->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('agence_acc','agence_acc.id = site.id_agence_acc')                       
                        ->join('cisco','cisco.id = convention_cisco_feffi_entete.id_cisco')                       
                        ->join('feffi','feffi.id = convention_cisco_feffi_entete.id_feffi')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zap','ecole.id_zap = zap.id')
                        ->join('zone_subvention','zone_subvention.id = ecole.id_zone_subvention')
                        ->join('acces_zone','acces_zone.id = ecole.id_acces_zone')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')            
                        ->where($requete)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findmontantreliquat($requete) {
    $this->db->select("convention_cisco_feffi_entete.*,convention_cisco_feffi_entete.id as id_conv,
        agence_acc.nom as nom_agence,ecole.description as nom_ecole, ecole.code as code_ecole, fokontany.nom as nom_fokontany,commune.nom as nom_commune,cisco.description as nom_cisco,region.nom as nom_region,zone_subvention.libelle as libelle_zone,acces_zone.libelle as libelle_acces,feffi.denomination as nom_feffi");

            $this->db ->select("(select (cout_maitrise_construction.cout + mobilier_construction.cout_unitaire + latrine_construction.cout_unitaire + batiment_construction.cout_unitaire + cout_sousprojet_construction.cout) from cout_maitrise_construction, mobilier_construction, latrine_construction, batiment_construction, cout_sousprojet_construction where cout_maitrise_construction.id_convention_entete= convention_cisco_feffi_entete.id and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and batiment_construction.id_convention_entete= convention_cisco_feffi_entete.id and cout_sousprojet_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as montant_convention",FALSE);

           

            $this->db ->select("(select sum(decaiss_fonct_feffi.montant) from decaiss_fonct_feffi, convention_cisco_feffi_entete where decaiss_fonct_feffi.id_convention_entete= convention_cisco_feffi_entete.id and decaiss_fonct_feffi.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as montant_decaiss_fonct_feffi",FALSE); 



//PAIEMENT MPE
            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='1') as montant_paiement_mpe1",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='2') as montant_paiement_mpe2",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='3') as montant_paiement_mpe3",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='4') as montant_paiement_mpe4",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='5') as montant_paiement_mpe5",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='6') as montant_paiement_mpe6",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='7') as montant_paiement_mpe7",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='8') as montant_paiement_mpe8",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='9') as montant_paiement_mpe9",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='10') as montant_paiement_mpe10",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.numero='11') as montant_paiement_mpe11",FALSE);

            $this->db ->select("(select facture_mpe.net_payer from pv_consta_entete_travaux,facture_mpe, contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.id=(select max(fact_mpe.id) from facture_mpe as fact_mpe,pv_consta_entete_travaux as atta_tra, contrat_prestataire as contra_m, convention_cisco_feffi_entete as conve_m where fact_mpe.id_pv_consta_entete_travaux=atta_tra.id and atta_tra.id_contrat_prestataire=contra_m.id and contra_m.id_convention_entete= conve_m.id and fact_mpe.validation = '4' and conve_m.id = id_conv and fact_mpe.id <(select max(fact_mpe.id) from facture_mpe as fact_mp,pv_consta_entete_travaux as atta_tr, contrat_prestataire as contra_mp, convention_cisco_feffi_entete as conve_mp where fact_mp.id_pv_consta_entete_travaux=atta_tr.id and atta_tr.id_contrat_prestataire=contra_mp.id and contra_mp.id_convention_entete= conve_mp.id and fact_mp.validation = '4' and conve_mp.id = id_conv))) as anterieur_mpe",FALSE);

                $this->db ->select("(select sum(facture_mpe.net_payer) from pv_consta_entete_travaux,facture_mpe, contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv) as cumul_mpe",FALSE);

                $this->db ->select("(select facture_mpe.net_payer from pv_consta_entete_travaux,facture_mpe, contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire=contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv and facture_mpe.id=(select max(fact_mpe.id) from facture_mpe as fact_mpe,pv_consta_entete_travaux as atta_tra, contrat_prestataire as contra_m, convention_cisco_feffi_entete as conve_m where fact_mpe.id_pv_consta_entete_travaux=atta_tra.id and atta_tra.id_contrat_prestataire=contra_m.id and contra_m.id_convention_entete= conve_m.id and fact_mpe.validation = '4' and conve_m.id = id_conv )) as periode_mpe",FALSE);

    $result =  $this->db->from('convention_cisco_feffi_entete')
                        
                        ->where("convention_cisco_feffi_entete.validation",2)
                        ->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('site','site.id = convention_cisco_feffi_entete.id_site')
                        ->join('agence_acc','agence_acc.id = site.id_agence_acc')                       
                        ->join('cisco','cisco.id = convention_cisco_feffi_entete.id_cisco')                       
                        ->join('feffi','feffi.id = convention_cisco_feffi_entete.id_feffi')
                        ->join('ecole','ecole.id = site.id_ecole')
                        ->join('zone_subvention','zone_subvention.id = ecole.id_zone_subvention')
                        ->join('acces_zone','acces_zone.id = ecole.id_acces_zone')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')            
                        ->where($requete)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findexporter_convention($requete) {
    $this->db->select("convention_cisco_feffi_entete.*,convention_cisco_feffi_entete.id as id_conv,
        agence_acc.nom as nom_agence,ecole.description as nom_ecole, ecole.code as code_ecole, fokontany.nom as nom_fokontany,commune.nom as nom_commune,cisco.description as nom_cisco,region.nom as nom_region,zap.nom as nom_zap,zone_subvention.libelle as libelle_zone,acces_zone.libelle as libelle_acces,feffi.denomination as nom_feffi");

            $this->db ->select("(select compte_feffi.numero_compte from compte_feffi,feffi,convention_cisco_feffi_entete where compte_feffi.id_feffi=feffi.id and feffi.id=convention_cisco_feffi_entete.id_feffi  and convention_cisco_feffi_entete.id = id_conv) as numero_compte",FALSE);
            $this->db ->select("(select compte_feffi.nom_banque from compte_feffi,feffi,convention_cisco_feffi_entete where compte_feffi.id_feffi=feffi.id and feffi.id=convention_cisco_feffi_entete.id_feffi  and convention_cisco_feffi_entete.id = id_conv) as nom_banque",FALSE);

            $this->db ->select("(select compte_feffi.adresse_banque from compte_feffi,feffi,convention_cisco_feffi_entete where compte_feffi.id_feffi=feffi.id and feffi.id=convention_cisco_feffi_entete.id_feffi  and convention_cisco_feffi_entete.id = id_conv) as adresse_banque",FALSE);

            $this->db ->select("(select batiment_construction.cout_unitaire from batiment_construction where batiment_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as cout_batiment",FALSE);

            $this->db ->select("(select convention_cisco_feffi_detail.date_signature from convention_cisco_feffi_detail where convention_cisco_feffi_detail.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as date_signature_convention",FALSE);

            $this->db ->select("(select convention_cisco_feffi_detail.observation from convention_cisco_feffi_detail where convention_cisco_feffi_detail.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as observation_convention",FALSE);

            $this->db ->select("(select latrine_construction.cout_unitaire from latrine_construction where latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as cout_latrine",FALSE);

            $this->db ->select("(select mobilier_construction.cout_unitaire from mobilier_construction where mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as cout_mobilier",FALSE);

            $this->db ->select("(select cout_maitrise_construction.cout from cout_maitrise_construction where cout_maitrise_construction.id_convention_entete= convention_cisco_feffi_entete.id  and convention_cisco_feffi_entete.id = id_conv) as cout_maitrise",FALSE);


            $this->db ->select("(select (cout_maitrise_construction.cout + mobilier_construction.cout_unitaire + latrine_construction.cout_unitaire + batiment_construction.cout_unitaire) from cout_maitrise_construction, mobilier_construction, latrine_construction, batiment_construction where cout_maitrise_construction.id_convention_entete= convention_cisco_feffi_entete.id and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and batiment_construction.id_convention_entete= convention_cisco_feffi_entete.id  and convention_cisco_feffi_entete.id = id_conv) as soustotaldepense",FALSE);

            $this->db ->select("(select cout_sousprojet_construction.cout from cout_sousprojet_construction where cout_sousprojet_construction.id_convention_entete= convention_cisco_feffi_entete.id  and convention_cisco_feffi_entete.id = id_conv) as cout_sousprojet",FALSE);

            $this->db ->select("(select (cout_maitrise_construction.cout + mobilier_construction.cout_unitaire + latrine_construction.cout_unitaire + batiment_construction.cout_unitaire + cout_sousprojet_construction.cout) from cout_maitrise_construction, mobilier_construction, latrine_construction, batiment_construction, cout_sousprojet_construction where cout_maitrise_construction.id_convention_entete= convention_cisco_feffi_entete.id and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and batiment_construction.id_convention_entete= convention_cisco_feffi_entete.id and cout_sousprojet_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as montant_convention",FALSE);

            $this->db ->select("(select type_batiment.nbr_salle from type_batiment,batiment_construction where type_batiment.id = batiment_construction.id_type_batiment and batiment_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_salle",FALSE);

            $this->db ->select("(select type_latrine.nbr_box_latrine from type_latrine,latrine_construction where type_latrine.id = latrine_construction.id_type_latrine and latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_box_latrine",FALSE);

            $this->db ->select("(select type_latrine.nbr_point_eau from type_latrine,latrine_construction where type_latrine.id = latrine_construction.id_type_latrine and latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_point_eau",FALSE);

            $this->db ->select("(select type_mobilier.nbr_table_banc from type_mobilier,mobilier_construction where type_mobilier.id = mobilier_construction.id_type_mobilier and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_table_banc",FALSE);

            $this->db ->select("(select type_mobilier.nbr_table_maitre from type_mobilier,mobilier_construction where type_mobilier.id = mobilier_construction.id_type_mobilier and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_table_maitre",FALSE);

            $this->db ->select("(select type_mobilier.nbr_chaise_maitre from type_mobilier,mobilier_construction where type_mobilier.id = mobilier_construction.id_type_mobilier and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_chaise_maitre",FALSE);

            $this->db ->select("(select convention_cisco_feffi_detail.prev_beneficiaire from convention_cisco_feffi_detail where convention_cisco_feffi_detail.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_beneficiaire",FALSE);

            $this->db ->select("(select convention_cisco_feffi_detail.prev_nbr_ecole from convention_cisco_feffi_detail where convention_cisco_feffi_detail.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as prev_nbr_ecole",FALSE);


    $result =  $this->db->from('convention_cisco_feffi_entete,convention_cisco_feffi_detail,site,ecole,fokontany,commune,district,region,cisco,agence_acc,zone_subvention,acces_zone,feffi,zap')
                        
                        ->where("validation",2)
                        ->where('convention_cisco_feffi_detail.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->where('convention_cisco_feffi_entete.id_feffi = feffi.id')
                        ->where('site.id = convention_cisco_feffi_entete.id_site')
                        ->where('agence_acc.id = site.id_agence_acc')
                        ->where('ecole.id = site.id_ecole')
                        ->where('zap.id = ecole.id_zap')
                        ->where('zone_subvention.id = ecole.id_zone_subvention')
                        ->where('acces_zone.id = ecole.id_acces_zone')
                        ->where('fokontany.id = ecole.id_fokontany')
                        ->where('commune.id = fokontany.id_commune')
                        ->where('district.id = commune.id_district')
                        ->where('region.id = district.id_region')
                        ->where('cisco.id_district = district.id')
                        ->where($requete)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }


    public function findconventionByid_ecole($id_ecole)
    {               
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->join('feffi','feffi.id=convention_cisco_feffi_entete.id_feffi')
                        ->join('ecole','ecole.id=feffi.id_ecole')
                        ->where("validation",2)
                        ->where("ecole.id",$id_ecole)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
/*public function findconventionmaxBydate($date_today) // id=(select max(id) from convention_cisco_feffi_entete) and
    {
        $sql = "select *
                        from convention_cisco_feffi_entete
                        where date_creation = ".$date_today."";
        return $this->db->query($sql)->result();                  
    }*/

  
   public function findconventionmaxBydate($date_today)  //mande
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id=(select max(id) from convention_cisco_feffi_entete)")
                        ->where("date_creation",$date_today)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findByRef_convention($ref_convention) {
        $requete="select * from convention_cisco_feffi_entete where lower(ref_convention)='".$ref_convention."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }
    public function getconventionNeeddemandefeffivalidationbcaf()
    {
        $sql=" select 
                       convention.*
               from convention_cisco_feffi_entete as convention

               inner join demande_realimentation_feffi as demande on demande.id_convention_cife_entete = convention.id

                where 
                        demande.validation= 0
                            group by convention.id
             

            ";
            return $this->db->query($sql)->result();                  
    }
    public function getconventionNeeddemandefeffivalidationdpfi()
    {
        $sql=" select 
                       convention.*
               from convention_cisco_feffi_entete as convention

               inner join demande_realimentation_feffi as demande on demande.id_convention_cife_entete = convention.id

                where 
                        demande.validation= 5
                            group by convention.id
             

            ";
            return $this->db->query($sql)->result();                  
    }
    public function getconventionNeeddecaissfeffivalidationbcaf()
    {
        $sql=" select 
                       convention.*
               from convention_cisco_feffi_entete as convention

               inner join decaiss_fonct_feffi as decaiss on decaiss.id_convention_entete = convention.id

                where 
                        decaiss.validation= 0
                            group by convention.id
             

            ";
            return $this->db->query($sql)->result();                  
    }
    public function getconventionneedfacturevalidationBycisc($id_cisco_user)
    {
        $sql=" select 
                         convention.id as id,
                        convention.id_feffi as id_feffi,
                        convention.id_site as id_site,
                        convention.id_cisco as id_cisco,
                        convention.type_convention as type_convention,
                        convention.ref_convention as ref_convention,
                        convention.objet as objet,
                        convention.ref_financement as ref_financement,
                        convention.id_user as id_user,
                        0 as nbr_demande_d_moe,
                        0 as nbr_demande_batiment_moe,
                        0 as nbr_demande_latrine_moe,
                        0 as nbr_demande_f_moe,
                        0 as nbr_fact_mpe

                        from convention_cisco_feffi_entete as convention
                        where 
                             convention.id_cisco='".$id_cisco_user."'
                            group by convention.id
            ";
            return $this->db->query($sql)->result();                   
    }
    public function getconventionneedfacturevalidationBycisco($id_cisco)
    {
        $sql=" select 
                        niveau2.id as id,
                        niveau2.id_feffi as id_feffi,
                        niveau2.id_site as id_site,
                        niveau2.id_cisco as id_cisco,
                        niveau2.type_convention as type_convention,
                        niveau2.ref_convention as ref_convention,
                        niveau2.objet as objet,
                        niveau2.ref_financement as ref_financement,
                        niveau2.id_user as id_user,
                        niveau2.date_creation as date_creation,
                        sum(niveau2.nbrdemande) as nbrdemande
               from (


                    select 
                            detail.id as id,
                            detail.id_feffi as id_feffi,
                            detail.id_site as id_site,
                            detail.id_cisco as id_cisco,
                            detail.type_convention as type_convention,
                            detail.ref_convention as ref_convention,
                            detail.objet as objet,
                            detail.ref_financement as ref_financement,
                            detail.id_user as id_user,
                            detail.date_creation as date_creation,
                            (sum(detail.nbr_fact_moe)+sum(detail.nbr_fact_mpe)+sum(detail.avance_dem)) as nbrdemande
                       
                       from (
                       
                        (
                            select 
                                
                                convention.id as id,  
                                convention.id_feffi as id_feffi,
                                convention.id_site as id_site,
                                convention.id_cisco as id_cisco,
                                convention.type_convention as type_convention,
                                convention.ref_convention as ref_convention,
                                convention.objet as objet,
                                convention.ref_financement as ref_financement,
                                convention.id_user as id_user,
                                convention.date_creation as date_creation,
                                count(fact_moe.id) as nbr_fact_moe,
                                0 as nbr_fact_mpe,
                                0 as avance_dem

                                from convention_cisco_feffi_entete as convention
                                inner join contrat_bureau_etude as contrat_moe on contrat_moe.id_convention_entete = convention.id
                                inner join facture_moe_entete as fact_moe on fact_moe.id_contrat_bureau_etude = contrat_moe.id
                                where 
                                    fact_moe.validation= 0 and convention.id_cisco='".$id_cisco."'
                                    group by convention.id
                        )
                        UNION
                        (
                            select 
                                 convention.id as id,
                                convention.id_feffi as id_feffi,
                                convention.id_site as id_site,
                                convention.id_cisco as id_cisco,
                                convention.type_convention as type_convention,
                                convention.ref_convention as ref_convention,
                                convention.objet as objet,
                                convention.ref_financement as ref_financement,
                                convention.id_user as id_user,
                                convention.date_creation as date_creation,
                                0 as nbr_fact_moe,
                                count(fact_mpe.id) as nbr_fact_mpe,
                                0 as avance_dem

                                from convention_cisco_feffi_entete as convention
                                inner join contrat_prestataire as contrat_mpe on contrat_mpe.id_convention_entete = convention.id
                                inner join attachement_travaux as atta_tra on atta_tra.id_contrat_prestataire = contrat_mpe.id
                                inner join facture_mpe as fact_mpe on fact_mpe.id_attachement_travaux = atta_tra.id
                                where 
                                    fact_mpe.validation= 0 and convention.id_cisco='".$id_cisco."'
                                    group by convention.id
                        )
                        UNION
                        (
                            select 
                                 convention.id as id,
                                convention.id_feffi as id_feffi,
                                convention.id_site as id_site,
                                convention.id_cisco as id_cisco,
                                convention.type_convention as type_convention,
                                convention.ref_convention as ref_convention,
                                convention.objet as objet,
                                convention.ref_financement as ref_financement,
                                convention.id_user as id_user,
                                convention.date_creation as date_creation,
                                0 as nbr_fact_moe,
                                0 as nbr_fact_mpe,
                                count(avance.id) as avance_dem

                                from convention_cisco_feffi_entete as convention
                                inner join contrat_prestataire as contrat_mpe on contrat_mpe.id_convention_entete = convention.id
                                inner join avance_demarrage as avance on avance.id_contrat_prestataire = contrat_mpe.id
                                where 
                                    avance.validation= 0 and convention.id_cisco='".$id_cisco."'
                                    group by convention.id
                        )
                        UNION
                        (
                            select 
                                 convention.id as id,
                                convention.id_feffi as id_feffi,
                                convention.id_site as id_site,
                                convention.id_cisco as id_cisco,
                                convention.type_convention as type_convention,
                                convention.ref_convention as ref_convention,
                                convention.objet as objet,
                                convention.ref_financement as ref_financement,
                                convention.id_user as id_user,
                                convention.date_creation as date_creation,
                                0 as nbr_fact_moe,
                                0 as nbr_fact_mpe,
                                0 as avance_dem

                                from convention_cisco_feffi_entete as convention
                                where 
                                     convention.id_cisco='".$id_cisco."'
                                    group by convention.id
                        )
                        )detail
                   
                        group by detail.id

                            )niveau2
                            where niveau2.nbrdemande >0
                            group by niveau2.id
            ";
            return $this->db->query($sql)->result();                   
    }
    public function getconventionneedfacturevalidation()
    {
        $sql=" select 
                        niveau2.id as id,
                        niveau2.id_feffi as id_feffi,
                        niveau2.id_site as id_site,
                        niveau2.id_cisco as id_cisco,
                        niveau2.id_region as id_region,
                        niveau2.id_convention_ufpdaaf as id_convention_ufpdaaf,
                        niveau2.type_convention as type_convention,
                        niveau2.ref_convention as ref_convention,
                        niveau2.objet as objet,
                        niveau2.ref_financement as ref_financement,
                        niveau2.id_user as id_user,
                        niveau2.date_creation as date_creation,
                        sum(niveau2.nbrdemande) as nbrdemande
               from (


                    select 
                            detail.id as id,
                            detail.id_feffi as id_feffi,
                            detail.id_site as id_site,
                            detail.id_cisco as id_cisco,
                            detail.id_region as id_region,
                            detail.id_convention_ufpdaaf as id_convention_ufpdaaf,
                            detail.type_convention as type_convention,
                            detail.ref_convention as ref_convention,
                            detail.objet as objet,
                            detail.ref_financement as ref_financement,
                            detail.id_user as id_user,
                            detail.date_creation as date_creation,
                            (sum(detail.nbr_fact_moe)+sum(detail.nbr_fact_mpe)+sum(detail.avance_dem)) as nbrdemande
                       
                       from (
                       
                        (
                            select 
                                
                                convention.id as id,  
                                convention.id_feffi as id_feffi,
                                convention.id_site as id_site,
                                convention.id_cisco as id_cisco,
                                convention.id_region as id_region,
                                convention.id_convention_ufpdaaf as id_convention_ufpdaaf,
                                convention.type_convention as type_convention,
                                convention.ref_convention as ref_convention,
                                convention.objet as objet,
                                convention.ref_financement as ref_financement,
                                convention.id_user as id_user,
                                convention.date_creation as date_creation,
                                count(fact_moe.id) as nbr_fact_moe,
                                0 as nbr_fact_mpe,
                                0 as avance_dem

                                from convention_cisco_feffi_entete as convention
                                inner join contrat_bureau_etude as contrat_moe on contrat_moe.id_convention_entete = convention.id
                                inner join facture_moe_entete as fact_moe on fact_moe.id_contrat_bureau_etude = contrat_moe.id
                                where 
                                    fact_moe.validation= 0 and fact_moe.statu_fact= 2
                                    group by convention.id
                        )
                        UNION
                        (
                            select 
                                 convention.id as id,
                                convention.id_feffi as id_feffi,
                                convention.id_site as id_site,
                                convention.id_cisco as id_cisco,
                                convention.id_region as id_region,
                                convention.id_convention_ufpdaaf as id_convention_ufpdaaf,
                                convention.type_convention as type_convention,
                                convention.ref_convention as ref_convention,
                                convention.objet as objet,
                                convention.ref_financement as ref_financement,
                                convention.id_user as id_user,
                                convention.date_creation as date_creation,
                                0 as nbr_fact_moe,
                                count(fact_mpe.id) as nbr_fact_mpe,
                                0 as avance_dem

                                from convention_cisco_feffi_entete as convention
                                inner join contrat_prestataire as contrat_mpe on contrat_mpe.id_convention_entete = convention.id
                                inner join pv_consta_entete_travaux as atta_tra on atta_tra.id_contrat_prestataire = contrat_mpe.id
                                inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux = atta_tra.id
                                where 
                                    fact_mpe.validation= 0
                                    group by convention.id
                        )
                        UNION
                        (
                            select 
                                 convention.id as id,
                                convention.id_feffi as id_feffi,
                                convention.id_site as id_site,
                                convention.id_cisco as id_cisco,
                                convention.id_region as id_region,
                                convention.id_convention_ufpdaaf as id_convention_ufpdaaf,
                                convention.type_convention as type_convention,
                                convention.ref_convention as ref_convention,
                                convention.objet as objet,
                                convention.ref_financement as ref_financement,
                                convention.id_user as id_user,
                                convention.date_creation as date_creation,
                                0 as nbr_fact_moe,
                                0 as nbr_fact_mpe,
                                count(avance.id) as avance_dem

                                from convention_cisco_feffi_entete as convention
                                inner join contrat_prestataire as contrat_mpe on contrat_mpe.id_convention_entete = convention.id
                                inner join avance_demarrage as avance on avance.id_contrat_prestataire = contrat_mpe.id

                                    group by convention.id
                        )
                        UNION
                        (
                            select 
                                 convention.id as id,
                                convention.id_feffi as id_feffi,
                                convention.id_site as id_site,
                                convention.id_cisco as id_cisco,
                                convention.id_region as id_region,
                                convention.id_convention_ufpdaaf as id_convention_ufpdaaf,
                                convention.type_convention as type_convention,
                                convention.ref_convention as ref_convention,
                                convention.objet as objet,
                                convention.ref_financement as ref_financement,
                                convention.id_user as id_user,
                                convention.date_creation as date_creation,
                                0 as nbr_fact_moe,
                                0 as nbr_fact_mpe,
                                0 as avance_dem

                                from convention_cisco_feffi_entete as convention
                                
                                    group by convention.id
                        )
                        )detail
                   
                        group by detail.id

                            )niveau2
                            where niveau2.nbrdemande >0
                            group by niveau2.id
            ";
            return $this->db->query($sql)->result();                   
    }
    public function getconventionNeeddemandefeffivalidationbcafwithcisco($id_cisco_user)
    {
        $sql=" select 
                       convention.*
               from convention_cisco_feffi_entete as convention

               inner join demande_realimentation_feffi as demande on demande.id_convention_cife_entete = convention.id

                where 
                        demande.validation= 0 and convention.id_cisco='".$id_cisco_user."'
                            group by convention.id
             

            ";
            return $this->db->query($sql)->result();                  
    }
    public function getconventionNeeddecaissfeffivalidationbcafwithcisco($id_cisco_user)
    {
        $sql=" select 
                       convention.*
               from convention_cisco_feffi_entete as convention

               inner join decaiss_fonct_feffi as decaiss on decaiss.id_convention_entete = convention.id

                where 
                        decaiss.validation= 0 and convention.id_cisco='".$id_cisco_user."'
                            group by convention.id
             

            ";
            return $this->db->query($sql)->result();                  
    }

    public function getconventionNeeddemandefeffivalidationdaaf()
    {
        $sql=" select 
                       convention.*,
                       count(demande.id)
               from convention_cisco_feffi_entete as convention

               inner join demande_realimentation_feffi as demande on demande.id_convention_cife_entete = convention.id

                where 
                        demande.validation= 6
                            group by convention.id
                            having count(demande.id)>0
             

            ";
            return $this->db->query($sql)->result();                  
    }
    public function getconventionNeeddemandefeffivalidationufp()
    {
        $sql=" select 
                       convention.*,
                       count(demande.id)
               from convention_cisco_feffi_entete as convention

               inner join demande_realimentation_feffi as demande on demande.id_convention_cife_entete = convention.id

                where 
                        demande.validation= 1
                            group by convention.id
                            having count(demande.id)>0
             

            ";
            return $this->db->query($sql)->result();                  
    }
  /*  public function getconventionNeeddemandefeffivalidationufp()
    {
        $sql=" select 
                       convention.*,
                       count(demande.id)
               from convention_cisco_feffi_entete as convention

               inner join demande_realimentation_feffi as demande on demande.id_convention_cife_entete = convention.id

                where 
                        demande.validation= 1
                            group by convention.id
                            having count(demande.id)>0
             

            ";
            return $this->db->query($sql)->result();                  
    }*/

    public function getconventionNeedvalidationpdfi()
    {
        $sql=" select 
                       convention.*,
                       count(fact_mpe.id),
                       count(fact_moe_entete.id),
                       count(avance.id)
               from convention_cisco_feffi_entete as convention

               inner join contrat_prestataire as contrat_p on contrat_p.id_convention_entete = convention.id
               inner join contrat_bureau_etude as contrat_b on contrat_b.id_convention_entete = convention.id
               left join pv_consta_entete_travaux as atta_mpe on atta_mpe.id_contrat_prestataire = contrat_p.id
               left join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux = atta_mpe.id
               left join facture_moe_entete as fact_moe_entete on fact_moe_entete.id_contrat_bureau_etude = contrat_b.id
               left join avance_demarrage as avance on avance.id_contrat_prestataire = contrat_p.id

                        where 
                            fact_mpe.validation= 1 OR fact_moe_entete.validation=1 OR avance.validation=1
                            group by convention.id
                            having (count(fact_mpe.id)>0 OR count(fact_moe_entete.id)>0) OR count(avance.id)>0
             

            ";
            return $this->db->query($sql)->result();                  
    }

   
     public function countConventionbyciscovalidation($id_cisco,$validation)
    {
        $result = $this->db->select('COUNT(*) as nombre')
                        ->from($this->table)
                        ->where("validation", $validation)
                        ->where("id_cisco", $id_cisco)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
   
    /* public function countConventionbyvalidation($validation)
    {
        $result = $this->db->select('COUNT(*) as nombre')
                        ->from($this->table)
                        ->where("validation", $validation)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }*/
    public function countConventionbyvalidation($validation)
    {
        $sql="
                    select 
                        count(conv.id) as nombre

                        from convention_cisco_feffi_entete as conv
                        where 
                            conv.validation= '".$validation."'
                

            ";
            return $this->db->query($sql)->result();                  
    }
    

    public function convention_cisco_feffi_avancement($id_convention_ufpdaaf)
    {               
        $this->db->select("convention_cisco_feffi_entete.id as id_conv, convention_cisco_feffi_entete.*");
        
            $this->db ->select("(
                select sum(detail_bat_travaux.periode) from pv_consta_detail_bat_travaux as detail_bat_travaux
                    inner join pv_consta_entete_travaux as entete_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                    
                    where 
                    entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                        inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                        inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                        inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                        where convent.id=id_conv and fac_mpe.validation=2)) as periode_bat",FALSE);
                $this->db ->select("(
                    select sum(detail_lat_travaux.periode) from pv_consta_detail_lat_travaux as detail_lat_travaux
                        inner join pv_consta_entete_travaux as entete_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        
                        where 
                            entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                                inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                                inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                                where convent.id=id_conv and fac_mpe.validation=2)) as periode_lat",FALSE);  
                $this->db ->select("(
                    select sum(detail_mob_travaux.periode) from pv_consta_detail_mob_travaux as detail_mob_travaux
                        inner join pv_consta_entete_travaux as entete_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        
                        where 
                            entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                                inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                                inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                                where convent.id=id_conv and fac_mpe.validation=2)) as periode_mob",FALSE);
                
                $this->db ->select("(
                    select sum(detail_bat_travaux.periode) from pv_consta_detail_bat_travaux as detail_bat_travaux
                        inner join pv_consta_entete_travaux as entete_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                        inner join convention_cisco_feffi_entete as convention on convention.id= contrat_mpe.id_convention_entete
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                            convention.id=id_conv and fact_mpe.validation=2 and
                            entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                                inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                                inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                                where convent.id=id_conv and fac_mpe.validation=2)) as anterieur_bat",FALSE);
                $this->db ->select("(
                    select sum(detail_lat_travaux.periode) from pv_consta_detail_lat_travaux as detail_lat_travaux
                            inner join pv_consta_entete_travaux as entete_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                            inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as convention on convention.id= contrat_mpe.id_convention_entete
                            inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                            where 
                                convention.id=id_conv and fact_mpe.validation=2 and
                                entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                    inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                                    inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                                    inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                                    where convent.id=id_conv and fac_mpe.validation=2)) as anterieur_lat",FALSE);
                $this->db ->select("(
                    select sum(detail_mob_travaux.periode) from pv_consta_detail_mob_travaux as detail_mob_travaux
                        inner join pv_consta_entete_travaux as entete_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                        inner join convention_cisco_feffi_entete as convention on convention.id= contrat_mpe.id_convention_entete
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                            convention.id=id_conv and fact_mpe.validation=2 and
                            entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                                inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                                inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                                where convent.id=id_conv and fac_mpe.validation=2)) as anterieur_mob",FALSE);
            
            $this->db ->select("(
                select contrat_mpe.cout_batiment from contrat_prestataire as contrat_mpe
                    where contrat_mpe.id_convention_entete = id_conv ) as cout_batiment",FALSE);
            
            $this->db ->select("(
                select contrat_mpe.cout_latrine from contrat_prestataire as contrat_mpe
                    where contrat_mpe.id_convention_entete = id_conv ) as cout_latrine",FALSE);
            
            $this->db ->select("(
                select contrat_mpe.cout_mobilier from contrat_prestataire as contrat_mpe
                    where contrat_mpe.id_convention_entete = id_conv ) as cout_mobilier",FALSE);
            $this->db ->select("(
                select contrat_mpe.cout_mobilier + contrat_mpe.cout_latrine + contrat_mpe.cout_batiment  from contrat_prestataire as contrat_mpe
                    where contrat_mpe.id_convention_entete = id_conv ) as montant_contrat",FALSE);     

       
        $result =  $this->db->from('convention_cisco_feffi_entete')
                    
                    ->where('convention_cisco_feffi_entete.id_convention_ufpdaaf',$id_convention_ufpdaaf)
                    ->group_by('id_conv')
                                       
                    ->get()
                    ->result();


        if($result)
        {   
            return $result;
        }
        else
        {
            return $data=array();
        }               
    
    }

    public function findreporting($now,$date_last, $id_district)
    {               
        $this->db->select("convention_cisco_feffi_entete.id as id_conv, convention_cisco_feffi_entete.ref_convention as ref_convention , convention_cisco_feffi_entete.id_cisco as id_cisco, convention_cisco_feffi_entete.id_feffi as id_feffi");
        
            $this->db ->select("(
                select sum(detail_bat_travaux.periode) from pv_consta_detail_bat_travaux as detail_bat_travaux
                    inner join pv_consta_entete_travaux as entete_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                    
                    where 
                    entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                        inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                        inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                        inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                        where convent.id=id_conv and fac_mpe.validation=2)) as periode_bat",FALSE);
                $this->db ->select("(
                    select sum(detail_lat_travaux.periode) from pv_consta_detail_lat_travaux as detail_lat_travaux
                        inner join pv_consta_entete_travaux as entete_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        
                        where 
                            entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                                inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                                inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                                where convent.id=id_conv and fac_mpe.validation=2)) as periode_lat",FALSE);  
                $this->db ->select("(
                    select sum(detail_mob_travaux.periode) from pv_consta_detail_mob_travaux as detail_mob_travaux
                        inner join pv_consta_entete_travaux as entete_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        
                        where 
                            entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                                inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                                inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                                where convent.id=id_conv and fac_mpe.validation=2)) as periode_mob",FALSE);
                
                $this->db ->select("(
                    select sum(detail_bat_travaux.periode) from pv_consta_detail_bat_travaux as detail_bat_travaux
                        inner join pv_consta_entete_travaux as entete_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                        inner join convention_cisco_feffi_entete as convention on convention.id= contrat_mpe.id_convention_entete
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                            convention.id=id_conv and fact_mpe.validation=2 and
                            entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                                inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                                inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                                where convent.id=id_conv and fac_mpe.validation=2)) as anterieur_bat",FALSE);
                $this->db ->select("(
                    select sum(detail_lat_travaux.periode) from pv_consta_detail_lat_travaux as detail_lat_travaux
                            inner join pv_consta_entete_travaux as entete_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                            inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as convention on convention.id= contrat_mpe.id_convention_entete
                            inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                            where 
                                convention.id=id_conv and fact_mpe.validation=2 and
                                entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                    inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                                    inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                                    inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                                    where convent.id=id_conv and fac_mpe.validation=2)) as anterieur_lat",FALSE);
                $this->db ->select("(
                    select sum(detail_mob_travaux.periode) from pv_consta_detail_mob_travaux as detail_mob_travaux
                        inner join pv_consta_entete_travaux as entete_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                        inner join convention_cisco_feffi_entete as convention on convention.id= contrat_mpe.id_convention_entete
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                            convention.id=id_conv and fact_mpe.validation=2 and
                            entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id
                                inner join contrat_prestataire as contrat_m on contrat_m.id= tete_trav.id_contrat_prestataire
                                inner join convention_cisco_feffi_entete as convent on convent.id= contrat_m.id_convention_entete 
                                where convent.id=id_conv and fac_mpe.validation=2)) as anterieur_mob",FALSE);
            
            $this->db ->select("(
                select contrat_mpe.cout_batiment from contrat_prestataire as contrat_mpe
                    where contrat_mpe.id_convention_entete = id_conv ) as cout_batiment",FALSE);
            
            $this->db ->select("(
                select contrat_mpe.cout_latrine from contrat_prestataire as contrat_mpe
                    where contrat_mpe.id_convention_entete = id_conv ) as cout_latrine",FALSE);
            
            $this->db ->select("(
                select contrat_mpe.cout_mobilier from contrat_prestataire as contrat_mpe
                    where contrat_mpe.id_convention_entete = id_conv ) as cout_mobilier",FALSE);
            $this->db ->select("(
                select contrat_mpe.cout_mobilier + contrat_mpe.cout_latrine + contrat_mpe.cout_batiment  from contrat_prestataire as contrat_mpe
                    where contrat_mpe.id_convention_entete = id_conv ) as montant_contrat",FALSE);
     /*$this->db ->select("(
                select max(avanc_lat.pourcentage) from avancement_physi_latrine as avanc_lat
                    inner join contrat_prestataire as cont_prest on cont_prest.id=avanc_lat.id_contrat_prestataire
            where cont_prest.id_convention_entete = id_conv ) as avancement_latrine",FALSE);

         $this->db ->select("(
                select max(avanc_mob.pourcentage) from avancement_physi_mobilier as avanc_mob
                    inner join contrat_prestataire as cont_prest on cont_prest.id=avanc_mob.id_contrat_prestataire
            where cont_prest.id_convention_entete = id_conv ) as avancement_mobilier",FALSE);   */     

       
        $result =  $this->db->from('convention_cisco_feffi_entete,convention_cisco_feffi_detail,cisco')
                    
                    ->where('convention_cisco_feffi_entete.id_cisco=cisco.id')
                    ->where('cisco.id_district',$id_district)
                    ->where('convention_cisco_feffi_detail.id_convention_entete=convention_cisco_feffi_entete.id')
                    ->where("DATE_FORMAT(convention_cisco_feffi_detail.date_signature,'%Y') BETWEEN '".$date_last."' AND '".$now."'")
                    ->where('convention_cisco_feffi_entete.validation',2)
                    ->group_by('id_conv')
                                       
                    ->get()
                    ->result();


        if($result)
        {   
            return $result;
        }
        else
        {
            return $data=array();
        }               
    
    }

   /* public function findreporting($now,$date_last, $id_district)
    {               
        $this->db->select("convention_cisco_feffi_entete.id as id_conv, convention_cisco_feffi_entete.ref_convention as ref_convention , convention_cisco_feffi_entete.id_cisco as id_cisco, convention_cisco_feffi_entete.id_feffi as id_feffi");
        
            $this->db ->select("(
                select max(avanc_bat.pourcentage) from avancement_physi_batiment as avanc_bat
                    inner join contrat_prestataire as cont_prest on cont_prest.id=avanc_bat.id_contrat_prestataire
            where cont_prest.id_convention_entete = id_conv ) as avancement_batiment",FALSE);
        
        $this->db ->select("(
                select max(avanc_lat.pourcentage) from avancement_physi_latrine as avanc_lat
                    inner join contrat_prestataire as cont_prest on cont_prest.id=avanc_lat.id_contrat_prestataire
            where cont_prest.id_convention_entete = id_conv ) as avancement_latrine",FALSE);

         $this->db ->select("(
                select max(avanc_mob.pourcentage) from avancement_physi_mobilier as avanc_mob
                    inner join contrat_prestataire as cont_prest on cont_prest.id=avanc_mob.id_contrat_prestataire
            where cont_prest.id_convention_entete = id_conv ) as avancement_mobilier",FALSE);        

        $result =  $this->db->from('convention_cisco_feffi_entete,convention_cisco_feffi_detail,cisco')
                    
                    ->where('convention_cisco_feffi_entete.id_cisco=cisco.id')
                    ->where('cisco.id_district',$id_district)
                    ->where('convention_cisco_feffi_detail.id_convention_entete=convention_cisco_feffi_entete.id')
                    ->where("DATE_FORMAT(convention_cisco_feffi_detail.date_signature,'%Y') BETWEEN '".$date_last."' AND '".$now."'")
                    ->where('convention_cisco_feffi_entete.validation',2)
                    ->group_by('id_conv')
                                       
                    ->get()
                    ->result();


        if($result)
        {   
            return $result;
        }
        else
        {
            return $data=array();
        }               
    
    }*/
    
    public function getconventiontest($convention) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('lower(ref_convention)=',$convention)
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
