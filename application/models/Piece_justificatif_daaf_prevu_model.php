<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Piece_justificatif_daaf_prevu_model extends CI_Model {
    protected $table = 'Piece_justificatif_daaf_prevu';

    public function add($Piece_justificatif_daaf_prevu) {
        $this->db->set($this->_set($Piece_justificatif_daaf_prevu))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $Piece_justificatif_daaf_prevu) {
        $this->db->set($this->_set($Piece_justificatif_daaf_prevu))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($Piece_justificatif_daaf_prevu) {
        return array(
            'code'       =>      $Piece_justificatif_daaf_prevu['code'],
            'intitule'   =>      $Piece_justificatif_daaf_prevu['intitule'],
            'id_tranche'   =>      $Piece_justificatif_daaf_prevu['id_tranche']                       
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

    public function findpieceBytranche($id_tranche) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_tranche',$id_tranche)
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


    public function finddocumentinvalideByconvention($id_convention_entete) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_feffi_scan as id_document_feffi_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_convention_entete as id_convention_entete,
                        detail.validation as validation

                    from
                (select 
                        doc_feffi.id as id, 
                        doc_feffi.code as code, 
                        doc_feffi.intitule as intitule,
                        doc_scan.id as id_document_feffi_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_convention_entete as id_convention_entete,
                        doc_scan.validation as validation 

                    from document_feffi_scan as doc_scan
            
                        right join document_feffi as doc_feffi on doc_scan.id_document_feffi = doc_feffi.id 
            
                        where doc_scan.id_convention_entete = ".$id_convention_entete." and doc_scan.validation=0
            
                        group by doc_feffi.id 
                UNION 

                select 
                        doc_feffi.id as id, 
                        doc_feffi.code as code, 
                        doc_feffi.intitule as intitule,
                        null as id_document_feffi_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_convention_entete,
                        null as validation  

                    from document_feffi as doc_feffi
            
                        group by doc_feffi.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

    public function finddocumentvalideByconvention($id_convention_entete) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_feffi_scan as id_document_feffi_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_convention_entete as id_convention_entete,
                        detail.validation as validation

                    from
                (select 
                        doc_feffi.id as id, 
                        doc_feffi.code as code, 
                        doc_feffi.intitule as intitule,
                        doc_scan.id as id_document_feffi_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_convention_entete as id_convention_entete,
                        doc_scan.validation as validation 

                    from document_feffi_scan as doc_scan
            
                        right join document_feffi as doc_feffi on doc_scan.id_document_feffi = doc_feffi.id 
            
                        where doc_scan.id_convention_entete = ".$id_convention_entete." and doc_scan.validation=1
            
                        group by doc_feffi.id 
                UNION 

                select 
                        doc_feffi.id as id, 
                        doc_feffi.code as code, 
                        doc_feffi.intitule as intitule,
                        null as id_document_feffi_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_convention_entete,
                        null as validation  

                    from document_feffi as doc_feffi
            
                        group by doc_feffi.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

    public function finddocumentByconvention($id_convention_entete) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_feffi_scan as id_document_feffi_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_convention_entete as id_convention_entete,
                        detail.validation as validation

                    from
                (select 
                        doc_feffi.id as id, 
                        doc_feffi.code as code, 
                        doc_feffi.intitule as intitule,
                        doc_scan.id as id_document_feffi_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_convention_entete as id_convention_entete,
                        doc_scan.validation as validation 

                    from document_feffi_scan as doc_scan
            
                        right join document_feffi as doc_feffi on doc_scan.id_document_feffi = doc_feffi.id 
            
                        where doc_scan.id_convention_entete = ".$id_convention_entete."
            
                        group by doc_feffi.id 
                UNION 

                select 
                        doc_feffi.id as id, 
                        doc_feffi.code as code, 
                        doc_feffi.intitule as intitule,
                        null as id_document_feffi_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_convention_entete,
                        null as validation  

                    from document_feffi as doc_feffi
            
                        group by doc_feffi.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

    public function findAllByConvention($id_convention_entete) {               
       /* $result =  $this->db->select('document_feffi.id as id, document_feffi.code as code, document_feffi.intitule as intitule, document_feffi_scan.id as id_document_feffi_scan, document_feffi_scan.fichier as fichier, document_feffi_scan.date_elaboration as date_elaboration, document_feffi_scan.observation as observation, document_feffi_scan.id_convention_entete as id_convention_entete')
                        ->from($this->table)
                        ->join('document_feffi_scan','document_feffi_scan.id_document_feffi=document_feffi.id','left')
                        //->order_by('document_feffi.code')
                        ->where('document_feffi_scan.id_convention_entete',$id_convention_entete)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        } */
       /* $sql=" select document_feffi.id as id, document_feffi.code as code, document_feffi.intitule as intitule, document_feffi_scan.id as id_document_feffi_scan, document_feffi_scan.fichier as fichier, document_feffi_scan.date_elaboration as date_elaboration, document_feffi_scan.observation as observation, document_feffi_scan.id_convention_entete as id_convention_entete from document_feffi left join document_feffi_scan on document_feffi_scan.id_document_feffi = document_feffi.id group by document_feffi.id ";
        return $this->db->query($sql)->result();  */

        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_feffi_scan as id_document_feffi_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_convention_entete as id_convention_entete

                    from
                (select 
                        doc_feffi.id as id, 
                        doc_feffi.code as code, 
                        doc_feffi.intitule as intitule,
                        doc_scan.id as id_document_feffi_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_convention_entete as id_convention_entete 

                    from document_feffi_scan as doc_scan
            
                        right join document_feffi as doc_feffi on doc_scan.id_document_feffi = doc_feffi.id 
            
                        where doc_scan.id_convention_entete = ".$id_convention_entete."
            
                        group by doc_feffi.id 
                UNION 

                select 
                        doc_feffi.id as id, 
                        doc_feffi.code as code, 
                        doc_feffi.intitule as intitule,
                        null as id_document_feffi_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_convention_entete 

                    from document_feffi as doc_feffi
            
                        group by doc_feffi.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

}
