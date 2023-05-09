<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_emies_model extends CI_Model {
    protected $table = 'module_emies';

    public function add($module_emies) {
        $this->db->set($this->_set($module_emies))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $module_emies) {
        $this->db->set($this->_set($module_emies))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($module_emies) {
        return array( 
            //'id' => $module_emies['id'],
            'date_debut_previ_form' => $module_emies['date_debut_previ_form'],
            'date_fin_previ_form'   => $module_emies['date_fin_previ_form'],
            'date_previ_resti'    => $module_emies['date_previ_resti'],
            'date_debut_reel_form' => $module_emies['date_debut_reel_form'],
            'date_fin_reel_form' => $module_emies['date_fin_reel_form'],
            'date_reel_resti' => $module_emies['date_reel_resti'],
            'nbr_previ_parti'   => $module_emies['nbr_previ_parti'],
            'nbr_previ_fem_parti'   => $module_emies['nbr_previ_fem_parti'],
            'lieu_formation' => $module_emies['lieu_formation'],
            'observation' => $module_emies['observation'],
            'id_contrat_partenaire_relai' => $module_emies['id_contrat_partenaire_relai'],
            'validation' => $module_emies['validation'],

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
       public function findinvalideBycontrat($id_contrat_partenaire_relai)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_partenaire_relai',$id_contrat_partenaire_relai)
                        ->where('validation',0)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findvalideBycontrat($id_contrat_partenaire_relai)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_partenaire_relai',$id_contrat_partenaire_relai)
                        ->where('validation',1)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findvalideById($id_module)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id',$id_module)
                        ->where('validation',1)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findmoduleBycontrat($id_contrat_partenaire_relai)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_partenaire_relai',$id_contrat_partenaire_relai)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getmoduleBycontrat($id_contrat_partenaire_relai)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_partenaire_relai',$id_contrat_partenaire_relai)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return $result=array();
        }                 
    }
    public function findByRef_convention($ref_convention) {
        $requete="select module_emies.* 
                    from module_emies 
                    inner join contrat_partenaire_relai on contrat_partenaire_relai.id=module_emies.id_contrat_partenaire_relai
                    inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id=contrat_partenaire_relai.id_convention_entete 
                    where lower(convention_cisco_feffi_entete.ref_convention)='".$ref_convention."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }

    /*    public function findAllBycontrat($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_partenaire_relai',$id_contrat_partenaire_relai)
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
    public function findAllByinvalide()
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('validation',0)
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


    public function findAllByDate()
    {               
        $sql=" select module_emies.* from module_emies where DATE_FORMAT(module_emies.date_debut_previ_form,'%Y') = DATE_FORMAT(now(),'%Y') and validation = 1 group by module_emies.id";
        return $this->db->query($sql)->result();                 
    }
    public function getmoduleBycontrat($id_contrat_partenaire_relai)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_partenaire_relai',$id_contrat_partenaire_relai)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/

}
