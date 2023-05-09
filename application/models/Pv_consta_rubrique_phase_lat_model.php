<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pv_consta_rubrique_phase_lat_model extends CI_Model {
    protected $table = 'pv_consta_rubrique_phase_lat';

    public function add($pv_consta_rubrique_phase_lat) {
        $this->db->set($this->_set($pv_consta_rubrique_phase_lat))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $pv_consta_rubrique_phase_lat) {
        $this->db->set($this->_set($pv_consta_rubrique_phase_lat))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($pv_consta_rubrique_phase_lat) {
        return array(
            'libelle'       =>      $pv_consta_rubrique_phase_lat['libelle'],
            'description'   =>      $pv_consta_rubrique_phase_lat['description'],
            'numero'    => $pv_consta_rubrique_phase_lat['numero'],
            'pourcentage_prevu'    => $pv_consta_rubrique_phase_lat['pourcentage_prevu']                        
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
                        ->order_by('numero')
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

    
    public function getpv_consta_rubrique_phase_pourcentagebycontrat($id_contrat_prestataire,$id_pv_consta_entete_travaux) {
        $this->db->select("pv_consta_rubrique_phase_lat.numero as numero, pv_consta_rubrique_phase_lat.libelle as libelle, pv_consta_rubrique_phase_lat.pourcentage_prevu as pourcentage_prevu,pv_consta_rubrique_phase_lat.id as id_phase");
    
        $this->db ->select("(select pv_consta_detail_lat_travaux.id 
                                        
                                        from pv_consta_detail_lat_travaux,pv_consta_entete_travaux 
                                            
                                            where pv_consta_detail_lat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id 
                                                    and pv_consta_detail_lat_travaux.id_rubrique_phase=id_phase  
                                                    and pv_consta_detail_lat_travaux.id_pv_consta_entete_travaux='".$id_pv_consta_entete_travaux."'
                                ) as id",FALSE);
            $this->db ->select("(select pv_consta_detail_lat_travaux.periode 
                                        
                                        from pv_consta_detail_lat_travaux,pv_consta_entete_travaux 
                                            
                                            where pv_consta_detail_lat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id 
                                                    and pv_consta_detail_lat_travaux.id_rubrique_phase=id_phase  
                                                    and pv_consta_detail_lat_travaux.id_pv_consta_entete_travaux='".$id_pv_consta_entete_travaux."'
                                ) as periode",FALSE);
            
            $this->db ->select("(select pv_consta_detail_lat_travaux.observation 
                                        
                                from pv_consta_detail_lat_travaux,pv_consta_entete_travaux 
                                    
                                    where pv_consta_detail_lat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id 
                                            and pv_consta_detail_lat_travaux.id_rubrique_phase=id_phase  
                                            and pv_consta_detail_lat_travaux.id_pv_consta_entete_travaux='".$id_pv_consta_entete_travaux."'
                        ) as observation",FALSE);

            $this->db ->select("(select sum(pv_consta_detail_lat_travaux.periode) 
                                        
                                from pv_consta_detail_lat_travaux,pv_consta_entete_travaux,facture_mpe 
                                    
                                    where pv_consta_detail_lat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id
                                            and pv_consta_entete_travaux.id=facture_mpe.id_pv_consta_entete_travaux 
                                            and pv_consta_entete_travaux.id_contrat_prestataire = '".$id_contrat_prestataire."' 
                                            and pv_consta_detail_lat_travaux.id_rubrique_phase=id_phase 
                                            and facture_mpe.validation=2 
                                            and pv_consta_detail_lat_travaux.id_pv_consta_entete_travaux<'".$id_pv_consta_entete_travaux."'
                                             
                        ) as anterieur",FALSE);
                
    
        $result =  $this->db->from('pv_consta_rubrique_phase_lat')
                            ->order_by('numero')
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
