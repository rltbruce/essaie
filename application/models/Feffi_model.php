<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feffi_model extends CI_Model {
    protected $table = 'feffi';

    public function add($feffi) {
        $this->db->set($this->_set($feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $feffi) {
        $this->db->set($this->_set($feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($feffi) {
        return array(
            'identifiant' => $feffi['identifiant'],
            'denomination' => $feffi['denomination'],
            'adresse' => $feffi['adresse'],
            'observation' => $feffi['observation'],
            'id_ecole'   =>      $feffi['id_ecole']                       
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
                        ->order_by('identifiant')
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

    public function findBycommune($id_commune) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_commune',$id_commune)
                        ->order_by('denomination')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findByecole($id_ecole)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_ecole',$id_ecole)
                        ->order_by('denomination')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findBycisco($id_cisco)
    {               
        $result =  $this->db->select('feffi.identifiant as identifiant, feffi.denomination as denomination, feffi.adresse as adresse, feffi.observation as observation, feffi.id as id, feffi.id_ecole as id_ecole')
                        ->from($this->table)
                        ->join('ecole','ecole.id=feffi.id_ecole')
                        ->join('fokontany','fokontany.id=ecole.id_fokontany')
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->join('district','district.id=commune.id_district')
                        ->join('cisco','cisco.id_district=district.id')
                        ->where('cisco.id',$id_cisco)
                        ->order_by('feffi.denomination')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findByfiltre($requete)
    {               
        $result =  $this->db->select('feffi.identifiant as identifiant, feffi.denomination as denomination, feffi.adresse as adresse, feffi.observation as observation, feffi.id as id, feffi.id_ecole as id_ecole')
                        ->from($this->table)
                        ->join('ecole','ecole.id=feffi.id_ecole')
                        ->join('fokontany','fokontany.id=ecole.id_fokontany')
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->join('district','district.id=commune.id_district')
                        ->join('region','region.id=district.id_region')
                        ->join('cisco','cisco.id_district=district.id')
                        ->where($requete)
                        ->order_by('feffi.denomination')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findByNom($nom) {
        $requete="select 
                        feffi.id as id, ecole.id_zone_subvention as id_zone_subvention,ecole.id_acces_zone as id_acces_zone 

                        from feffi inner join ecole on ecole.id=feffi.id_ecole 

                        where lower(feffi.denomination)='".$nom."'";

        $query = $this->db->query($requete);
        return $query->result();                
    }
    
    
    public function getfeffitest($id_ecole,$feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('lower(denomination)=',$feffi)
                        ->where("id_ecole", $id_ecole)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }

    
    public function getfeffibyfeffifokozapcisco($feffi,$fokontany,$zap,$cisco)
    {               
        $result =  $this->db->select('feffi.*')
                        ->from($this->table)
                        ->join('ecole','ecole.id=feffi.id_ecole')
                        ->join('fokontany','fokontany.id=ecole.id_fokontany')
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->join('district','district.id=commune.id_district')
                        ->join('cisco','cisco.id_district=district.id') 
                        ->join('zap_commune','zap_commune.id_commune=commune.id')  
                        ->join('zap','zap_commune.id_zap=zap.id')                       
                        ->where('lower(fokontany.nom)=',$fokontany)
                        ->where('lower(zap.nom)=',$zap)
                        ->where('lower(cisco.description)=',$cisco)
                        ->where('lower(feffi.denomination)=',$feffi)
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
