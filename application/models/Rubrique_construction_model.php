<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rubrique_construction_model extends CI_Model {
    protected $table = 'rubrique_construction';

    public function add($rubrique_construction) {
        $this->db->set($this->_set($rubrique_construction))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $rubrique_construction) {
        $this->db->set($this->_set($rubrique_construction))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($rubrique_construction) {
        return array(

            'id_rubrique_phase' => $rubrique_construction['id_rubrique_phase'],
            'id_phase_construction'    => $rubrique_construction['id_phase_construction'],
            'date_verification'   => $rubrique_construction['date_verification'],
            'conformite' => $rubrique_construction['conformite'],
            'observation' => $rubrique_construction['observation']                     
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

    public function findAllByPrestation_mpe($id_prestation_mpe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_prestation_mpe", $id_prestation_mpe)
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
            public function findAllByphase_construction($id_phase_construction) {               

        $sql=" 

                select detail.id_rubr_phase as id_rubr_phase, 
                        detail.designation as designation, 
                        detail.element_verifier as element_verifier,
                        detail.id_rubr_construction as id_rubr_construction, 
                        detail.conformite as conformite, 
                        detail.date_verification as date_verification, 
                        detail.observation as observation, 
                        detail.id_phase_construction as id_phase_construction

                    from
                (select 
                        rubr_phase.id as id_rubr_phase, 
                        rubr_phase.designation as designation, 
                        rubr_phase.element_verifier as element_verifier,
                        rubr_construction.id as id_rubr_construction, 
                        rubr_construction.conformite as conformite, 
                        rubr_construction.date_verification as date_verification, 
                        rubr_construction.observation as observation, 
                        rubr_construction.id_phase_construction as id_phase_construction 

                    from rubrique_construction as rubr_construction
                        inner join phase_sous_projet_construction as phase_construction on phase_construction.id = rubr_construction.id_phase_construction
                        right join rubrique_phase_sous_projet as rubr_phase on rubr_construction.id_rubrique_phase = rubr_phase.id 
            
                        where phase_construction.id = ".$id_phase_construction."
            
                        group by rubr_phase.id 
                UNION 

                select 
                        rubr_phase.id as id_rubr_phase, 
                        rubr_phase.designation as designation, 
                        rubr_phase.element_verifier as element_verifier,
                        null as id_rubr_construction, 
                        null as conformite, 
                        null as date_verification, 
                        null as observation, 
                        phase_construction.id as id_phase_construction 

                    from rubrique_phase_sous_projet as rubr_phase
                        inner join phase_sous_projets as phase_s_projet on phase_s_projet.id = rubr_phase.id_phase_sous_projet
                        inner join phase_sous_projet_construction as phase_construction on phase_construction.id_phase_sous_projet = phase_s_projet.id
                        where phase_construction.id = ".$id_phase_construction."
            
                        group by rubr_phase.id) detail
                group by detail.id_rubr_phase  ";
        return $this->db->query($sql)->result();                
    }

}
/*select 
                        rubr_phase.id as id_rubr_phase, 
                        rubr_phase.designation as designation, 
                        rubr_phase.element_verifier as element_verifier,
                        rubr_construction.id as id_rubr_contruction, 
                        rubr_construction.conformite as conformite, 
                        rubr_construction.date_verification as date_verification, 
                        rubr_construction.observation as observation, 
                        phase_construction.id as id_phase_construction 

                    from rubrique_construction as rubr_construction
                        inner join phase_sous_projet_construction as phase_construction on phase_construction.id = rubr_construction.id_phase_construction
                        right join rubrique_phase_sous_projet as rubr_phase on rubr_construction.id_rubrique_phase = rubr_phase.id 
            
                        where phase_construction.id = ".$id_phase_construction."
            
                        group by phase_construction.id 
                UNION 
                select 
                        rubr_phase.id as id_rubr_phase, 
                        rubr_phase.designation as designation, 
                        rubr_phase.element_verifier as element_verifier,
                        null as id_rubr_contruction, 
                        null as conformite, 
                        null as date_verification, 
                        null as observation, 
                        null as id_phase_construction 

                    from rubrique_phase_sous_projet as rubr_phase
                        inner join phase_sous_projets as phase_s_projet on phase_s_projet.id = rubr_phase.id_phase_sous_projet
                        inner join phase_sous_projet_construction as phase_construction on phase_construction.id_phase_sous_projet = phase_s_projet.id
                        
                        where phase_construction.id = ".$id_phase_construction."
                        group by phase_construction.id*/