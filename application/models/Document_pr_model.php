<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_pr_model extends CI_Model {
    protected $table = 'document_pr';

    public function add($document_pr) {
        $this->db->set($this->_set($document_pr))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $document_pr) {
        $this->db->set($this->_set($document_pr))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($document_pr) {
        return array(
            'code'       =>      $document_pr['code'],
            'intitule'   =>      $document_pr['intitule']                       
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

    public function finddocumentinvalideBycontrat($id_contrat_partenaire_relai) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_pr_scan as id_document_pr_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_partenaire_relai as id_contrat_partenaire_relai,
                        detail.validation as validation

                    from
                (select 
                        doc_pr.id as id, 
                        doc_pr.code as code, 
                        doc_pr.intitule as intitule,
                        doc_scan.id as id_document_pr_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_partenaire_relai as id_contrat_partenaire_relai,
                        doc_scan.validation as validation 

                    from document_pr_scan as doc_scan
            
                        right join document_pr as doc_pr on doc_scan.id_document_pr = doc_pr.id 
            
                        where doc_scan.id_contrat_partenaire_relai = ".$id_contrat_partenaire_relai." and doc_scan.validation=0
            
                        group by doc_pr.id 
                UNION 

                select 
                        doc_pr.id as id, 
                        doc_pr.code as code, 
                        doc_pr.intitule as intitule,
                        null as id_document_pr_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_partenaire_relai,
                        null as validation  

                    from document_pr as doc_pr
            
                        group by doc_pr.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

    public function finddocumentvalideBycontrat($id_contrat_partenaire_relai) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_pr_scan as id_document_pr_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_partenaire_relai as id_contrat_partenaire_relai,
                        detail.validation as validation

                    from
                (select 
                        doc_pr.id as id, 
                        doc_pr.code as code, 
                        doc_pr.intitule as intitule,
                        doc_scan.id as id_document_pr_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_partenaire_relai as id_contrat_partenaire_relai,
                        doc_scan.validation as validation 

                    from document_pr_scan as doc_scan
            
                        right join document_pr as doc_pr on doc_scan.id_document_pr = doc_pr.id 
            
                        where doc_scan.id_contrat_partenaire_relai = ".$id_contrat_partenaire_relai." and doc_scan.validation=1
            
                        group by doc_pr.id 
                UNION 

                select 
                        doc_pr.id as id, 
                        doc_pr.code as code, 
                        doc_pr.intitule as intitule,
                        null as id_document_pr_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_partenaire_relai,
                        null as validation  

                    from document_pr as doc_pr
            
                        group by doc_pr.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

    public function finddocumentBycontrat($id_contrat_partenaire_relai) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_pr_scan as id_document_pr_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_partenaire_relai as id_contrat_partenaire_relai,
                        detail.validation as validation

                    from
                (select 
                        doc_pr.id as id, 
                        doc_pr.code as code, 
                        doc_pr.intitule as intitule,
                        doc_scan.id as id_document_pr_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_partenaire_relai as id_contrat_partenaire_relai,
                        doc_scan.validation as validation 

                    from document_pr_scan as doc_scan
            
                        right join document_pr as doc_pr on doc_scan.id_document_pr = doc_pr.id 
            
                        where doc_scan.id_contrat_partenaire_relai = ".$id_contrat_partenaire_relai."
            
                        group by doc_pr.id 
                UNION 

                select 
                        doc_pr.id as id, 
                        doc_pr.code as code, 
                        doc_pr.intitule as intitule,
                        null as id_document_pr_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_partenaire_relai,
                        null as validation  

                    from document_pr as doc_pr
            
                        group by doc_pr.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

    public function findAllByContrat($id_contrat_partenaire_relai) {               
       /* $result =  $this->db->select('document_pr.id as id, document_pr.code as code, document_pr.intitule as intitule, document_pr_scan.id as id_document_pr_scan, document_pr_scan.fichier as fichier, document_pr_scan.date_elaboration as date_elaboration, document_pr_scan.observation as observation, document_pr_scan.id_contrat_partenaire_relai as id_contrat_partenaire_relai')
                        ->from($this->table)
                        ->join('document_pr_scan','document_pr_scan.id_document_pr=document_pr.id','left')
                        //->order_by('document_pr.code')
                        ->where('document_pr_scan.id_contrat_partenaire_relai',$id_contrat_partenaire_relai)
                        ->get()
                        ->result();where document_pr_scan.id_contrat_partenaire_relai = ".$id_contrat_partenaire_relai."
        if($result)
        {
            return $result;
        }else{
            return null;
        } */
       /* $sql=" select 
                        document_pr.id as id, document_pr.code as code, 
                        document_pr.intitule as intitule,
                        document_pr_scan.id as id_document_pr_scan, 
                        document_pr_scan.fichier as fichier, 
                        document_pr_scan.date_elaboration as date_elaboration, 
                        document_pr_scan.observation as observation, 
                        document_pr_scan.id_contrat_partenaire_relai as id_contrat_partenaire_relai 

        from document_pr_scan 
            right outer join document_pr on document_pr_scan.id_document_pr = document_pr.id 
            where document_pr_scan.id_contrat_partenaire_relai = ".$id_contrat_partenaire_relai."
             group by document_pr.id ";
        return $this->db->query($sql)->result();  */  

        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_pr_scan as id_document_pr_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_partenaire_relai as id_contrat_partenaire_relai

                    from
                (select 
                        doc_pr.id as id, 
                        doc_pr.code as code, 
                        doc_pr.intitule as intitule,
                        doc_scan.id as id_document_pr_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_partenaire_relai as id_contrat_partenaire_relai 

                    from document_pr_scan as doc_scan
            
                        right join document_pr as doc_pr on doc_scan.id_document_pr = doc_pr.id 
            
                        where doc_scan.id_contrat_partenaire_relai = ".$id_contrat_partenaire_relai."
            
                        group by doc_pr.id 
                UNION 

                select 
                        doc_pr.id as id, 
                        doc_pr.code as code, 
                        doc_pr.intitule as intitule,
                        null as id_document_pr_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_partenaire_relai 

                    from document_pr as doc_pr
            
                        group by doc_pr.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();             
    }

        public function findAllByConvention($id_convention_entete) {               
         

        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_pr_scan as id_document_pr_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_partenaire_relai as id_contrat_partenaire_relai

                    from
                (select 
                        doc_pr.id as id, 
                        doc_pr.code as code, 
                        doc_pr.intitule as intitule,
                        doc_scan.id as id_document_pr_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_partenaire_relai as id_contrat_partenaire_relai 

                    from document_pr_scan as doc_scan
                        inner join contrat_partenaire_relai as contrat_parten on contrat_parten.id = doc_scan.id_contrat_partenaire_relai
                        right join document_pr as doc_pr on doc_scan.id_document_pr = doc_pr.id 
            
                        where contrat_parten.id_convention_entete = ".$id_convention_entete."
            
                        group by doc_pr.id 
                UNION 

                select 
                        doc_pr.id as id, 
                        doc_pr.code as code, 
                        doc_pr.intitule as intitule,
                        null as id_document_pr_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_partenaire_relai 

                    from document_pr as doc_pr
            
                        group by doc_pr.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();             
    }

}
