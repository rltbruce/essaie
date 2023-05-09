<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fokontany_model extends CI_Model {
    protected $table = 'fokontany';

    public function add($fokontany) {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($fokontany))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $fokontany) {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($fokontany))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fokontany) {
		// Affectation des valeurs
        return array(
            'code'       =>  $fokontany['code'],
            'nom'        =>  $fokontany['nom'],
            //'latitude'   =>  $fokontany['latitude'],
            //'longitude'  =>  $fokontany['longitude'],
            'id_commune' =>  $fokontany['id_commune']                       
        );
    }
    public function delete($id) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
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
	/*public function find_Fokontany_avec_Commune_et_District_et_Region($id=null) {
		// Selection fokotany avec description commune,district et region
		$requete='select f.id,f.nom,f.code,f.id_commune,c.nom as commune,c.district_id,d.nom as district,d.region_id,r.nom as region
                from fokontany as f
                left outer join commune as c on c.id=f.id_commune
				left outer join district as d on d.id=c.district_id
				left outer join region as r on r.id=d.region_id '
				.($id !=null ? ' where f.id='.$id : '')
				.' order by f.nom,c.nom,d.nom,r.nom	';				
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
        }else{
            return null;
        }  
	}
	public function find_Liste_Fokontany_avec_Commune_et_District_et_Region($id_commune=null) {
		// Selection fokontany par commune ; avec description district et région
		$requete='select f.id,f.nom,f.code,f.id_commune,c.nom as commune,c.district_id,d.nom as district,d.region_id,r.nom as region
                from fokontany as f
                left outer join commune as c on c.id=f.id_commune
				left outer join district as d on d.id=c.district_id
				left outer join region as r on r.id=d.region_id '
				.($id_commune !=null ? ' where f.id_commune='.$id_commune : '')
				.' order by f.nom,c.nom,d.nom,r.nom ';				
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
        }else{
            return null;
        }  
	}

    public function findAllByCommune($id_commune) 
	{	// Selection fokontany par id_commune
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('nom')
                        ->where("id_commune", $id_commune)
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }*/
    /*public function findById($id) {
		// Selection par id
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }*/	
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function findAllByCommune($id_commune) 
    {   // Selection fokontany par id_commune
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('nom')
                        ->where("id_commune", $id_commune)
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getfokontanynomtest($district,$commune,$fokontany) {               
        $result =  $this->db->select('fokontany.*')
                        ->from($this->table)
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->join('district','district.id=commune.id_district')
                        ->where('lower(fokontany.nom)=',$fokontany)
                        ->where("lower(commune.nom)=", $commune)
                        ->where("lower(district.nom)=", $district)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
    public function getfokontanytest($district,$commune,$fokontany) {               
        $result =  $this->db->select('fokontany.*')
                        ->from($this->table)
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->join('district','district.id=commune.id_district')
                        ->where('lower(fokontany.nom)=',$fokontany)
                        ->where("commune.id", $commune)
                        ->where("district.id", $district)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
    public function getfokontanytest2($commune,$fokontany) {               
        $result =  $this->db->select('fokontany.*')
                        ->from($this->table)
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->where('lower(fokontany.nom)=',$fokontany)
                        ->where("lower(commune.nom)=", $commune)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
    public function getfokontanytestbyid_commune($id_commune,$fokontany) {               
        $result =  $this->db->select('fokontany.*')
                        ->from($this->table)
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->where('lower(fokontany.nom)=',$fokontany)
                        ->where("commune.id=", $id_commune)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }

    
    public function getfokontanybyfokontanyzapcisco($fokontany,$zap,$cisco) {               
        $result =  $this->db->select('fokontany.*')
                        ->from($this->table)
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->join('zap_commune','zap_commune.id_commune=commune.id')
                        ->join('zap','zap_commune.id_zap=zap.id')
                        ->join('district','district.id=commune.id_district')
                        ->join('cisco','cisco.id_district=district.id')
                        ->where('lower(fokontany.nom)=',$fokontany)
                        ->where('lower(zap.nom)=',$zap)
                        ->where('lower(cisco.description)=',$cisco)
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
?>