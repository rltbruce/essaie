<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facture_moe_entete_model extends CI_Model {
    protected $table = 'facture_moe_entete';

    public function add($facture_moe_entete) {
        $this->db->set($this->_set($facture_moe_entete))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $facture_moe_entete) {
        $this->db->set($this->_set($facture_moe_entete))
                //->set('date_approbation', 'NOW()', false)
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($facture_moe_entete) {
        return array(
            'numero' => $facture_moe_entete['numero'],
            'date_br' => $facture_moe_entete['date_br'],
            'id_contrat_bureau_etude' => $facture_moe_entete['id_contrat_bureau_etude'],
            'validation'    =>  $facture_moe_entete['validation'],
            'statu_fact'    =>  $facture_moe_entete['statu_fact']                      
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
    public function getfacturedisponibleBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_bureau_etude',$id_contrat_bureau_etude)
                        ->where('validation >',0)
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
    public function getfacture_moe_enteteBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_bureau_etude',$id_contrat_bureau_etude)
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
    
    public function getfacture_moe_enteteinvalideBycontratstat12($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_bureau_etude',$id_contrat_bureau_etude)
                        ->where('validation',0)
                        //->where('statu_fact',2)
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
    public function getfacture_moe_enteteinvalideBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_bureau_etude',$id_contrat_bureau_etude)
                        ->where('validation',0)
                        ->where('statu_fact',2)
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


    public function getfactureemidpfiBycontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)                        
                        ->where("validation IN(1,2,3)")
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

    public function getfacture_moevalideById($id_facture_moe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id',$id_facture_moe)
                        ->where('validation >',0)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getfacture_moevalideBycontrat($id_contrat_bureau_etude)
    {               
        $this->db->select("facture_moe_entete.*, facture_moe_entete.id as id_fact,(contrat_bureau_etude.montant_contrat) as cout_contrat");
        
            $this->db ->select("(
                select cout_contrat-sum(facture_moe_detail.montant_periode) from facture_moe_detail 
                    inner join facture_moe_entete on facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete
                    where facture_moe_entete.id<= id_fact and facture_moe_entete.validation=2 and facture_moe_entete.id_contrat_bureau_etude= '".$id_contrat_bureau_etude."' ) as reste_payer",FALSE); 
            $this->db ->select("(
                        select sum(facture_moe_detail.montant_periode) from facture_moe_detail 
                            inner join facture_moe_entete on facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete
                            where facture_moe_entete.id= id_fact and facture_moe_entete.validation=2 ) as montant_facture",FALSE);
            $this->db ->select("(
                        select (sum(facture_moe_detail.montant_periode)*100)/cout_contrat from facture_moe_detail 
                            inner join facture_moe_entete on facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete
                            where facture_moe_entete.id= id_fact and facture_moe_entete.validation=2 ) as pourcentage",FALSE);       

        $result =  $this->db->from('facture_moe_entete')
                    
                    
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude')
                        ->where("facture_moe_entete.id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("facture_moe_entete.validation", 2)
                        ->order_by('id')
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
        

}
