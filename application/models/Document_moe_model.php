<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_moe_model extends CI_Model {
    protected $table = 'document_moe';

    public function add($document_moe) {
        $this->db->set($this->_set($document_moe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $document_moe) {
        $this->db->set($this->_set($document_moe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($document_moe) {
        return array(
            'code'       =>      $document_moe['code'],
            'intitule'   =>      $document_moe['intitule']                       
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
                        ->order_by('intitule')
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


    public function finddocumentinvalideBycontrat($id_contrat_bureau_etude) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_moe_scan as id_document_moe_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_bureau_etude as id_contrat_bureau_etude,
                        detail.validation as validation

                    from
                (select 
                        doc_moe.id as id, 
                        doc_moe.code as code, 
                        doc_moe.intitule as intitule,
                        doc_scan.id as id_document_moe_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_bureau_etude as id_contrat_bureau_etude,
                        doc_scan.validation as validation 

                    from document_moe_scan as doc_scan
            
                        right join document_moe as doc_moe on doc_scan.id_document_moe = doc_moe.id 
            
                        where doc_scan.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and doc_scan.validation=0
            
                        group by doc_moe.id 
                UNION 

                select 
                        doc_moe.id as id, 
                        doc_moe.code as code, 
                        doc_moe.intitule as intitule,
                        null as id_document_moe_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_bureau_etude,
                        null as validation  

                    from document_moe as doc_moe
            
                        group by doc_moe.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

    public function finddocumentvalideBycontrat($id_contrat_bureau_etude) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_moe_scan as id_document_moe_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_bureau_etude as id_contrat_bureau_etude,
                        detail.validation as validation

                    from
                (select 
                        doc_moe.id as id, 
                        doc_moe.code as code, 
                        doc_moe.intitule as intitule,
                        doc_scan.id as id_document_moe_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_bureau_etude as id_contrat_bureau_etude,
                        doc_scan.validation as validation 

                    from document_moe_scan as doc_scan
            
                        right join document_moe as doc_moe on doc_scan.id_document_moe = doc_moe.id 
            
                        where doc_scan.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and doc_scan.validation=1
            
                        group by doc_moe.id 
                UNION 

                select 
                        doc_moe.id as id, 
                        doc_moe.code as code, 
                        doc_moe.intitule as intitule,
                        null as id_document_moe_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_bureau_etude,
                        null as validation  

                    from document_moe as doc_moe
            
                        group by doc_moe.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

    public function finddocumentBycontrat($id_contrat_bureau_etude) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_moe_scan as id_document_moe_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_bureau_etude as id_contrat_bureau_etude,
                        detail.validation as validation

                    from
                (select 
                        doc_moe.id as id, 
                        doc_moe.code as code, 
                        doc_moe.intitule as intitule,
                        doc_scan.id as id_document_moe_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_bureau_etude as id_contrat_bureau_etude,
                        doc_scan.validation as validation 

                    from document_moe_scan as doc_scan
            
                        right join document_moe as doc_moe on doc_scan.id_document_moe = doc_moe.id 
            
                        where doc_scan.id_contrat_bureau_etude = ".$id_contrat_bureau_etude."
            
                        group by doc_moe.id 
                UNION 

                select 
                        doc_moe.id as id, 
                        doc_moe.code as code, 
                        doc_moe.intitule as intitule,
                        null as id_document_moe_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_bureau_etude,
                        null as validation  

                    from document_moe as doc_moe
            
                        group by doc_moe.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

    public function findAllByContrat($id_contrat_bureau_etude) {               
       /* $result =  $this->db->select('document_moe.id as id, document_moe.code as code, document_moe.intitule as intitule, document_moe_scan.id as id_document_moe_scan, document_moe_scan.fichier as fichier, document_moe_scan.date_elaboration as date_elaboration, document_moe_scan.observation as observation, document_moe_scan.id_contrat_bureau_etude as id_contrat_bureau_etude')
                        ->from($this->table)
                        ->join('document_moe_scan','document_moe_scan.id_document_moe=document_moe.id','left')
                        //->order_by('document_moe.code')
                        ->where('document_moe_scan.id_contrat_bureau_etude',$id_contrat_bureau_etude)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        } */
        /*$sql=" select document_moe.id as id, document_moe.code as code, document_moe.intitule as intitule, document_moe_scan.id as id_document_moe_scan, document_moe_scan.fichier as fichier, document_moe_scan.date_elaboration as date_elaboration, document_moe_scan.observation as observation, document_moe_scan.id_contrat_bureau_etude as id_contrat_bureau_etude from document_moe left join document_moe_scan on document_moe_scan.id_document_moe = document_moe.id group by document_moe.id ";
        return $this->db->query($sql)->result();   */ 
        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_moe_scan as id_document_moe_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_bureau_etude as id_contrat_bureau_etude

                    from
                (select 
                        doc_moe.id as id, 
                        doc_moe.code as code, 
                        doc_moe.intitule as intitule,
                        doc_scan.id as id_document_moe_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_bureau_etude as id_contrat_bureau_etude 

                    from document_moe_scan as doc_scan
            
                        right join document_moe as doc_moe on doc_scan.id_document_moe = doc_moe.id 
            
                        where doc_scan.id_contrat_bureau_etude = ".$id_contrat_bureau_etude."
            
                        group by doc_moe.id 
                UNION 

                select 
                        doc_moe.id as id, 
                        doc_moe.code as code, 
                        doc_moe.intitule as intitule,
                        null as id_document_moe_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_bureau_etude 

                    from document_moe as doc_moe
            
                        group by doc_moe.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();              
    }

        public function findAllByConvention($id_convention_entete) {               

        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_moe_scan as id_document_moe_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_bureau_etude as id_contrat_bureau_etude

                    from
                (select 
                        doc_moe.id as id, 
                        doc_moe.code as code, 
                        doc_moe.intitule as intitule,
                        doc_scan.id as id_document_moe_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_bureau_etude as id_contrat_bureau_etude 

                    from document_moe_scan as doc_scan
                        inner join contrat_bureau_etude as contrat_bureau on contrat_bureau.id = doc_scan.id_contrat_bureau_etude
                        right join document_moe as doc_moe on doc_scan.id_document_moe = doc_moe.id 
            
                        where contrat_bureau.id_convention_entete = ".$id_convention_entete."
            
                        group by doc_moe.id 
                UNION 

                select 
                        doc_moe.id as id, 
                        doc_moe.code as code, 
                        doc_moe.intitule as intitule,
                        null as id_document_moe_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_bureau_etude 

                    from document_moe as doc_moe
            
                        group by doc_moe.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();              
    }


}
