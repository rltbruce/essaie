<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ecole_model extends CI_Model {
    protected $table = 'ecole';

    public function add($ecole) {
        $this->db->set($this->_set($ecole))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $ecole) {
        $this->db->set($this->_set($ecole))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($ecole) {
        return array(
            'code'          =>      $ecole['code'],
            'lieu'          =>      $ecole['lieu'],
            'description'   =>      $ecole['description'],
            'latitude'      =>      $ecole['latitude'],
            'longitude'     =>      $ecole['longitude'],
            'altitude'      =>      $ecole['altitude'],
            'id_zone_subvention' => $ecole['id_zone_subvention'],
            'id_acces_zone' => $ecole['id_acces_zone'],
            'id_fokontany'    =>    $ecole['id_fokontany'] ,
            'id_cisco'    =>    $ecole['id_cisco'],
            'id_commune'    =>    $ecole['id_commune'],
            'id_zap'    =>    $ecole['id_zap'],
            'id_region'    =>    $ecole['id_region']                         
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
                        ->order_by('description')
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
        $result =  $this->db->select('ecole.*')
                        ->from($this->table)
                        //->join('fokontany','fokontany.id=ecole.id_fokontany')
                        //->join('commune','commune.id=fokontany.id_commune')
                        ->where('id_commune',$id_commune)
                        ->order_by('ecole.description')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findByzap($id_zap) {               
        $result =  $this->db->select('ecole.*')
                        ->from($this->table)
                        //->join('fokontany','fokontany.id=ecole.id_fokontany')
                        //->join('commune','commune.id=fokontany.id_commune')
                        //->join('zap_commune','zap_commune.id_commune=commune.id')
                        ->where('id_zap',$id_zap)
                        ->order_by('ecole.description')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findByIdZone($id)  {
        $this->db->select('ecole.id as id,ecole.code as code,ecole.description as description,zone_subvention.libelle as libelle_zone,acces_zone.libelle as libelle_acces,zone_subvention.id as id_zone_subvention,acces_zone.id as id_acces_zone')
        ->where("ecole.id", $id)
        ->join('zone_subvention','zone_subvention.id=ecole.id_zone_subvention')
        ->join('acces_zone','acces_zone.id=ecole.id_acces_zone');
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    } 

    public function findBycisco($id_cisco)
    {               
        $result =  $this->db->select('ecole.*')
                        ->from($this->table)
                        //->join('fokontany','fokontany.id=ecole.id_fokontany')
                        //->join('commune','commune.id=fokontany.id_commune')
                        //->join('district','district.id=commune.id_district')
                        //->join('cisco','cisco.id_district=district.id')
                        ->where('id_cisco',$id_cisco)
                        ->order_by('ecole.code')
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
        $result =  $this->db->select('DISTINCT(ecole.id) as id_dist,ecole.*')
                        ->from($this->table)
                        ->join('fokontany','fokontany.id=ecole.id_fokontany')
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->join('district','district.id=commune.id_district')
                        ->join('cisco','cisco.id_district=district.id')
                        ->join('region','region.id=district.id_region')
                        ->where($requete)
                        ->order_by('ecole.code')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getecoletest($id_region,$id_cisco,$id_commune,$id_zap,$id_fokontany,$eco)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_region',$id_region)
                        ->where('id_cisco',$id_cisco)
                        ->where('id_commune',$id_commune)
                        ->where('id_zap',$id_zap)
                        ->where('id_fokontany',$id_fokontany)
                        ->where('lower(ecole.description)=',$eco)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getecoletest2($district,$commune,$fokontany,$eco)
    {               
        $result =  $this->db->select('ecole.*')
                        ->from($this->table)
                        ->join('fokontany','fokontany.id=ecole.id_fokontany')
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->join('district','district.id=commune.id_district')
                        ->join('cisco','cisco.id_district=district.id')
                        ->where('lower(ecole.description)=',$eco)
                        ->where('lower(district.nom)=',$district)
                        ->where('lower(commune.nom)=',$commune)
                        ->where('lower(fokontany.nom)=',$fokontany)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getecoletestbyid_fokontany($id_fokontany,$econ)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_fokontany',$id_fokontany)
                        ->where('lower(ecole.description)=',$econ)
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
