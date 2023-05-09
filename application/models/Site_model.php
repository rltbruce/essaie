<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_model extends CI_Model {
    protected $table = 'site';

    public function add($site) {
        $this->db->set($this->_set($site))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $site) {
        $this->db->set($this->_set($site))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($site) {
        return array( 

            'code_sous_projet' =>      $site['code_sous_projet'],
            'objet_sous_projet' =>      $site['objet_sous_projet'],
            //'denomination_epp' =>      $site['denomination_epp'],
            'id_agence_acc' =>      $site['id_agence_acc'],
            'statu_convention' =>      $site['statu_convention'],
            'observation' =>      $site['observation'],
            'id_region' => $site['id_region'],
            'id_cisco' => $site['id_cisco'],
            'id_commune' => $site['id_commune'],
            'id_zap' => $site['id_zap'],
            'id_ecole' =>      $site['id_ecole'],
            'id_classification_site' =>      $site['id_classification_site'],
            'lot' =>      $site['lot'],
            'validation' =>      $site['validation'],
            'acces' =>      $site['acces']                      
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
    public function findsiteByenpreparationinvalide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('statu_convention',0)
                        ->where('validation',0)
                        ->order_by('code_sous_projet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findsiteByenpreparationandinvalide($requete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('statu_convention',0)
                        ->where('validation',0)
                        ->where($requete)
                        ->order_by('code_sous_projet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findsiteByIdandvalide($id_site) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id',$id_site)
                        ->where('validation',1)
                        ->order_by('code_sous_projet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findsitecreeByfeffi($id_feffi) {               
        $result =  $this->db->select('site.*')
                        ->from($this->table)
                        ->join('ecole','ecole.id=site.id_ecole')
                        ->join('feffi','feffi.id_ecole=ecole.id')
                        ->where('feffi.id',$id_feffi)
                        ->where('statu_convention',0)
                        ->order_by('site.id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function findsite_etat($requete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where($requete)
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
    
    public function findsiteByfiltre($requete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where($requete)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
   /* public function findsiteInvalide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('validation',0)
                        ->order_by('code_sous_projet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findsiteByenpreparation() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('statu_convention',0)
                        ->order_by('code_sous_projet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findsiteByfiltreinvalide($requete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('validation',0)
                        ->where($requete)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findsite_disponible($requete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where($requete)
                        ->where('statu_convention',0)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/
   /* public function findsiteByfiltre($requete) {               
        $result =  $this->db->select('site.*')
                        ->from($this->table)
                        ->join('ecole','ecole.id=site.id_ecole')
                        ->join('zap','zap.id = ecole.id_zap')
                        ->join('fokontany','fokontany.id = ecole.id_fokontany')
                        ->join('commune','commune.id = fokontany.id_commune')
                        ->join('district','district.id = commune.id_district')
                        ->join('region','region.id = district.id_region')
                        ->join('cisco','cisco.id_district = district.id')
                        ->where($requete)                        
                        ->order_by('ecole.description')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/
   /* public function findByCode($nom) {
        $requete="select * from site where lower(code_sous_projet)='".$nom."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }*/

}
