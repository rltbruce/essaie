<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_deblocage_daaf_model extends CI_Model {
    protected $table = 'demande_deblocage_daaf';

    public function add($demande_deblocage_daaf) {
        $this->db->set($this->_set($demande_deblocage_daaf))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_deblocage_daaf) {
        $this->db->set($this->_set($demande_deblocage_daaf))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($demande_deblocage_daaf) {
        return array(
            'objet'        =>$demande_deblocage_daaf['objet'],
            'ref_demande'  =>$demande_deblocage_daaf['ref_demande'],
            'prevu'   =>$demande_deblocage_daaf['prevu'],
            'id_tranche_deblocage_daaf' =>$demande_deblocage_daaf['id_tranche_deblocage_daaf'],
            'anterieur' =>$demande_deblocage_daaf['anterieur'],
            'cumul' =>$demande_deblocage_daaf['cumul'],
            'reste' =>$demande_deblocage_daaf['reste'],
            'date'  =>$demande_deblocage_daaf['date'],
            'id_convention_ufp_daaf_entete'    =>  $demande_deblocage_daaf['id_convention_ufp_daaf_entete'],
            'id_compte_daaf'    =>  $demande_deblocage_daaf['id_compte_daaf'],
            'validation'    =>  $demande_deblocage_daaf['validation']                         
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
                        ->order_by('objet')
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

    public function findAllByconvention_ufpdaaf($id_convention_ufpdaaf) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_ufp_daaf_entete", $id_convention_ufpdaaf)
                        ->order_by('objet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function finddemandeByvalidationconvention($id_convention_ufpdaaf,$validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_ufp_daaf_entete", $id_convention_ufpdaaf)
                        ->where("validation", $validation)
                        ->order_by('objet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getdemande_deblocageById($id_demande_deblocage_daaf) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_demande_deblocage_daaf)
                        ->where("validation !=", 0)
                        ->order_by('objet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findDisponibleByconvention_ufpdaaf($id_convention_ufp_daaf_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_ufp_daaf_entete", $id_convention_ufp_daaf_entete)
                        ->where("validation >", 0)
                        ->order_by('objet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
        public function getdemande_deblocage_daaf($id_convention_ufp_daaf_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_ufp_daaf_entete", $id_convention_ufp_daaf_entete)
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
        public function getdemande_deblocage_daaf_invalide($validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",$validation )
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

    public function countAllByInvalide($invalide)
    {
        $result = $this->db->select('COUNT(*) as nombre')
                        ->from($this->table)
                        ->where("validation", $invalide)
                        ->order_by('id', 'desc')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }

    public function getmax_demande_daafbyconvention($id_convention_ufp_daaf_entete)
    {
        $sql = "select *
                        from demande_deblocage_daaf
                        where id=(select max(id) from demande_deblocage_daaf) and id_convention_ufp_daaf_entete =".$id_convention_ufp_daaf_entete."";
        return $this->db->query($sql)->result();                  
    }

       public function getdemandeinvalideufp($id_convention_ufp_daaf_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_ufp_daaf_entete",$id_convention_ufp_daaf_entete )
                        ->where("validation", 1)
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

}
