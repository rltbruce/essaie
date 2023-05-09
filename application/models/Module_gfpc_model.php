<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_gfpc_model extends CI_Model {
    protected $table = 'module_gfpc';

    public function add($module_gfpc) {
        $this->db->set($this->_set($module_gfpc))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $module_gfpc) {
        $this->db->set($this->_set($module_gfpc))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($module_gfpc) {
        return array( 
            //'id' => $module_gfpc['id'],
            'date_debut_previ_form' => $module_gfpc['date_debut_previ_form'],
            'date_fin_previ_form'   => $module_gfpc['date_fin_previ_form'],
            'date_previ_resti'    => $module_gfpc['date_previ_resti'],
            'date_debut_reel_form' => $module_gfpc['date_debut_reel_form'],
            'date_fin_reel_form' => $module_gfpc['date_fin_reel_form'],
            'date_reel_resti' => $module_gfpc['date_reel_resti'],
            'nbr_previ_parti'   => $module_gfpc['nbr_previ_parti'],
            'nbr_previ_fem_parti'   => $module_gfpc['nbr_previ_fem_parti'],
            'lieu_formation' => $module_gfpc['lieu_formation'],
            'observation' => $module_gfpc['observation'],
            'id_contrat_partenaire_relai' => $module_gfpc['id_contrat_partenaire_relai'],
            'validation' => $module_gfpc['validation'],

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
        $requete="select module_gfpc.* 
                    from module_gfpc 
                    inner join contrat_partenaire_relai on contrat_partenaire_relai.id=module_gfpc.id_contrat_partenaire_relai
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
        $sql=" select module_gfpc.* from module_gfpc where DATE_FORMAT(module_gfpc.date_debut_previ_form,'%Y') = DATE_FORMAT(now(),'%Y') and validation = 1 group by module_gfpc.id";
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
