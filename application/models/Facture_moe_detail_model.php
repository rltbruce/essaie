<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facture_moe_detail_model extends CI_Model {
    protected $table = 'facture_moe_detail';

    public function add($facture_moe_detail) {
        $this->db->set($this->_set($facture_moe_detail))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $facture_moe_detail) {
        $this->db->set($this->_set($facture_moe_detail))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($facture_moe_detail) {
        return array(
            'montant_periode'       =>      $facture_moe_detail['montant_periode'],
            'observation'       =>      $facture_moe_detail['observation'],
            'id_calendrier_paie_moe_prevu'   =>      $facture_moe_detail['id_calendrier_paie_moe_prevu'],
            'id_facture_moe_entete'    => $facture_moe_detail['id_facture_moe_entete']                       
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


     public function getfacture_moe_detailwithcalendrier_detailbyentete1($id_contrat_bureau_etude,$id_facture_moe_entete,$id_sousrubrique) {
        $sql="
                select detail.id as id, 
                        detail.id_calendrier_paie_moe_prevu as id_calendrier_paie_moe_prevu, 
                        detail.libelle as libelle,
                        sum(detail.montant_prevu) as montant_prevu ,
                        sum(detail.pourcentage) as pourcentage,
                        sum(detail.montant_periode) as montant_periode ,
                        detail.observation as observation ,
                        sum(detail.montant_anterieur) as montant_anterieur,
                        (sum(detail.montant_anterieur)+sum(detail.montant_periode)) as montant_cumul,
                        ((sum(detail.montant_periode)*100)/sum(detail.montant_prevu)) as pourcentage_periode,
                        ((sum(detail.montant_anterieur)*100)/sum(detail.montant_prevu)) as pourcentage_anterieur,
                        (((sum(detail.montant_anterieur)+sum(detail.montant_periode))*100)/sum(detail.montant_prevu)) as pourcentage_cumul

                    from
                (
                select 
                        calendrier_paie_moe_prevu.id as id_calendrier_paie_moe_prevu, 
                        sousrubrique_calendrier_detail.libelle as libelle,
                        null as id,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        null as observation,
                        0 as montant_anterieur 

                    from divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu
            
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail  
                        left join facture_moe_detail as fact_detail on fact_detail.id_calendrier_paie_moe_prevu=calendrier_paie_moe_prevu.id
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
            
                        group by sousrubrique_calendrier_detail.id 
                UNION 

                select 
                        calendrier_paie_moe_prevu.id as id_calendrier_paie_moe_prevu, 
                        sousrubrique_calendrier_detail.libelle as libelle,
                        null as id,
                        0 as montant_prevu,
                        sum(sousrubrique_calendrier_detail.pourcentage) as pourcentage,
                        0 as montant_periode,
                        null as observation,
                        0 as montant_anterieur  

                    from divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail
                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id_sousrubrique_detail = sousrubrique_calendrier_detail.id
                        left join facture_moe_detail as fact_detail on fact_detail.id_calendrier_paie_moe_prevu=calendrier_paie_moe_prevu.id
                        where  sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique." and calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude."

                        group by sousrubrique_calendrier_detail.id 
                UNION 

                select 
                        calendrier_paie_moe_prevu.id as id_calendrier_paie_moe_prevu, 
                        sousrubrique_calendrier_detail.libelle as libelle,
                        fact_detail.id as id,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        sum(fact_detail.montant_periode) as montant_periode,
                        fact_detail.observation as observation,
                        0 as montant_anterieur 

                    from facture_moe_detail as fact_detail
                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
            
                        group by sousrubrique_calendrier_detail.id 
                UNION

                select 
                        calendrier_paie_moe_prevu.id as id_calendrier_paie_moe_prevu,  
                        sousrubrique_calendrier_detail.libelle as libelle,
                        null as id,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        0 as montant_periode,
                        null as observation, 
                        sum(fact_detail.montant_periode) as montant_anterieur  

                    from facture_moe_detail as fact_detail
                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join facture_moe_entete as fact_entete on fact_entete.id=fact_detail.id_facture_moe_entete
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique." and fact_entete.id<".$id_facture_moe_entete." and fact_entete.validation=4 
                        group by sousrubrique_calendrier_detail.id) detail
                group by detail.id_calendrier_paie_moe_prevu order by detail.id_calendrier_paie_moe_prevu ";
        return $this->db->query($sql)->result();                
    }
    public function getfacture_moe_detailwithcalendrier_detailbyentete($id_contrat_bureau_etude,$id_facture_moe_entete,$id_sousrubrique)
    {
       $this->db->select("
            divers_sousrubrique_calendrier_paie_moe_detail.id as id_sousrubrique_detail,
            divers_sousrubrique_calendrier_paie_moe_detail.libelle as libelle,
            divers_sousrubrique_calendrier_paie_moe_detail.code as code,
            divers_sousrubrique_calendrier_paie_moe_detail.pourcentage as pourcentage,
            divers_calendrier_paie_moe_prevu.montant_prevu as montant_prevu");
       $this->db ->select("((
                select fact_detail.id 
                        
                        from facture_moe_detail as fact_detail 

                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." 
                                and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." 
                                and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                and sousrubrique_calendrier_detail.id=id_sousrubrique_detail)) as id",false);
       $this->db ->select("((
                select fact_detail.observation 
                        
                        from facture_moe_detail as fact_detail 

                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." 
                                and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." 
                                and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                and sousrubrique_calendrier_detail.id=id_sousrubrique_detail)) as observation",false);

            $this->db ->select("((
                select fact_detail.montant_periode 
                        
                        from facture_moe_detail as fact_detail 

                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." 
                                and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." 
                                and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                and sousrubrique_calendrier_detail.id=id_sousrubrique_detail)) as montant_periode",false); 
        $result =  $this->db->from('divers_sousrubrique_calendrier_paie_moe_detail,divers_calendrier_paie_moe_prevu')
                    
                    ->where('divers_sousrubrique_calendrier_paie_moe_detail.id = divers_calendrier_paie_moe_prevu.id_sousrubrique_detail')
                    ->where('id_contrat_bureau_etude',$id_contrat_bureau_etude)
                   
                    ->where('id_sousrubrique',$id_sousrubrique)
                    ->group_by('id_sousrubrique_detail')
                                       
                    ->get()
                    ->result();                              

        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }



    public function getcalendrier_detail($id_sousrubrique,$id_contrat_bureau_etude) {               
        $result =  $this->db->select('divers_sousrubrique_calendrier_paie_moe_detail.id as id_sousrubrique_detail,
                divers_sousrubrique_calendrier_paie_moe_detail.libelle as libelle,
                divers_sousrubrique_calendrier_paie_moe_detail.code as code,
                divers_sousrubrique_calendrier_paie_moe_detail.pourcentage as pourcentage,
                divers_calendrier_paie_moe_prevu.id as id_calendrier_paie_moe_prevu,
                divers_calendrier_paie_moe_prevu.montant_prevu as montant_prevu')
                        ->from('divers_sousrubrique_calendrier_paie_moe_detail')
                        ->join('divers_calendrier_paie_moe_prevu','divers_sousrubrique_calendrier_paie_moe_detail.id = divers_calendrier_paie_moe_prevu.id_sousrubrique_detail')
                        ->where('id_sousrubrique',$id_sousrubrique)
                        ->where('id_contrat_bureau_etude',$id_contrat_bureau_etude)
                        ->group_by('divers_sousrubrique_calendrier_paie_moe_detail.id')
                        ->order_by('code')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }


    public function getmontant_prevu_sous_rubrique($id_contrat_bureau_etude,$id_sousrubrique) {               
        $this->db->select('sum(divers_calendrier_paie_moe_prevu.montant_prevu) as montant_prevu,divers_sousrubrique_calendrier_paie_moe_detail.pourcentage as pourcentage')
                ->join("divers_sousrubrique_calendrier_paie_moe_detail", "divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail")
                        ->where('id_sousrubrique',$id_sousrubrique)
                        ->where('id_contrat_bureau_etude',$id_contrat_bureau_etude);
        $q = $this->db->get('divers_calendrier_paie_moe_prevu');
        if ($q->num_rows() > 0) {
            return $q->row();
        }                 
    }

    public function getfacture_detail_periodebycontrat($id_contrat_bureau_etude,$id_facture_moe_entete,$id_sousrubrique_detail)
     {
        $this->db->select("
            facture_moe_detail.montant_periode as montant_periode,
            facture_moe_detail.id as id,
            facture_moe_detail.observation as observation")
                
                ->join("facture_moe_entete", "facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete")
                ->join("divers_calendrier_paie_moe_prevu", "divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu")
                ->join("divers_sousrubrique_calendrier_paie_moe_detail", "divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail")
                ->where("facture_moe_entete.id_contrat_bureau_etude", $id_contrat_bureau_etude)
                ->where("facture_moe_entete.id", $id_facture_moe_entete)
                ->where("divers_sousrubrique_calendrier_paie_moe_detail.id", $id_sousrubrique_detail);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }                
    }

    public function getmontant_periodepbycontratcodep($id_contrat_bureau_etude,$code,$id_facture_moe_entete)
     {
        $this->db->select("facture_moe_detail.montant_periode as montant_periode")
                ->join("facture_moe_entete", "facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete")
                ->join("divers_calendrier_paie_moe_prevu", "divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu")
                ->join("divers_sousrubrique_calendrier_paie_moe_detail", "divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail")
                ->where("facture_moe_entete.id_contrat_bureau_etude", $id_contrat_bureau_etude)
                ->where("facture_moe_entete.id<", $id_facture_moe_entete)
                ->where("code", $code)
                ->where("validation", 2);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }                
    }
    public function getmontant_currentpbycontratcodep($id_contrat_bureau_etude,$code,$id_facture_moe_entete)
     {
        $this->db->join("facture_moe_entete", "facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete")
                ->join("divers_calendrier_paie_moe_prevu", "divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu")
                ->join("divers_sousrubrique_calendrier_paie_moe_detail", "divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail")
                ->where("facture_moe_entete.id_contrat_bureau_etude", $id_contrat_bureau_etude)
                ->where("facture_moe_entete.id", $id_facture_moe_entete)
                ->where("code", $code);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }                
    }
    public function getmontant_currentlatrinebycontrat($id_contrat_bureau_etude,$id_facture_moe_entete,$code)
     {
        $this->db->select("sum(facture_moe_detail.montant_periode) as montant_periode")
                ->join("facture_moe_entete", "facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete")
                ->join("divers_calendrier_paie_moe_prevu", "divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu")
                ->join("divers_sousrubrique_calendrier_paie_moe_detail", "divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail")
                ->where("facture_moe_entete.id_contrat_bureau_etude", $id_contrat_bureau_etude)
                ->where("facture_moe_entete.id>=", $id_facture_moe_entete)
                ->where_in("code", $code)
                ->where_in("validation",[2,0]);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }                
    }
    public function getmontant_anterieurbycontrat($id_contrat_bureau_etude,$code)
     {
        $result =  $this->db->select("sum(facture_moe_detail.montant_periode )as montant_periode,divers_calendrier_paie_moe_prevu.montant_prevu ")
                        ->from($this->table)
                        ->join("divers_calendrier_paie_moe_prevu", "divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu")
                        ->join("divers_sousrubrique_calendrier_paie_moe_detail", "divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail")
                        ->where("divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("code", $code)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }               
    }

    public function getmontant_anterieurbycontratbyid($id_contrat_bureau_etude,$code,$id_facture_detail_moe)
     {
        $result =  $this->db->select("sum(facture_moe_detail.montant_periode )as montant_periode,divers_calendrier_paie_moe_prevu.montant_prevu ")
                        ->from($this->table)
                        ->join("divers_calendrier_paie_moe_prevu", "divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu")
                        ->join("divers_sousrubrique_calendrier_paie_moe_detail", "divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail")
                        ->where("divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("facture_moe_detail.id<", $id_facture_detail_moe)
                        ->where("code", $code)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }               
    }
    public function getmontant_anterieur_p8bycontrat($id_contrat_bureau_etude)
     {
        $result =  $this->db->select("sum(facture_moe_detail.montant_periode )as montant_periode, sum(divers_calendrier_paie_moe_prevu.montant_prevu) as montant_prevu")
                        ->from($this->table)
                        ->join("divers_calendrier_paie_moe_prevu", "divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu",'right')
                        ->join("divers_sousrubrique_calendrier_paie_moe_detail", "divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail")
                        ->where("divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("code!=", 'p8')
                        ->where("code!=", 'p9')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }               
    }
    public function getmontant_anterieur_p9bycontrat($id_contrat_bureau_etude)
     {
        $result =  $this->db->select("sum(facture_moe_detail.montant_periode )as montant_periode, sum(divers_calendrier_paie_moe_prevu.montant_prevu) as montant_prevu")
                        ->from($this->table)
                        ->join("divers_calendrier_paie_moe_prevu", "divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu",'right')
                        ->join("divers_sousrubrique_calendrier_paie_moe_detail", "divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail")
                        ->where("divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("code!=", 'p9')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }               
    }
    
    /*public function getfacturedetailbyconventionandcode($id_convention_entete,$code)
     {
        $result =  $this->db->select("sum(facture_moe_detail.montant_periode )as montant_periode,
                                        facture_moe_detail.id as id_facture_detail,
                                        divers_calendrier_paie_moe_prevu.montant_prevu as montant_prevu,
                                        divers_calendrier_paie_moe_prevu.id as id_prevu,
                                        facture_moe_entete.id as id_facture_entete,
                                        ")
                        ->from($this->table)
                        ->join("divers_calendrier_paie_moe_prevu", "divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu")
                        ->join("divers_sousrubrique_calendrier_paie_moe_detail", "divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail")
                        ->join("contrat_bureau_etude", "contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude")
                        ->join("facture_moe_entete", "facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete")
                        ->where("contrat_bureau_etude.id_convention_entete", $id_convention_entete)
                        ->where("divers_sousrubrique_calendrier_paie_moe_detail.code", $code)
                        ->where("facture_moe_entete.validation IN(0,2)")
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }               
    }*/

    public function getfacturedetailsupprbyconventionandcode($id_convention_entete,$code)
    {
        $this->db->select("convention_cisco_feffi_entete.id as id_conv");
    
        $this->db ->select("(select facture_moe_detail.id 
                                        
                                        from facture_moe_detail,facture_moe_entete,divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                                            
                                            where facture_moe_detail.id_calendrier_paie_moe_prevu=divers_calendrier_paie_moe_prevu.id 
                                                    and facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete 
                                                    and divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu 
                                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail
                                                    and contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                                                    and contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
                                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='".$code."'
                                                    and facture_moe_entete.validation=0 and facture_moe_entete.statu_fact=1
                                ) as id_detail",FALSE);
        $this->db ->select("(select divers_calendrier_paie_moe_prevu.id 
                                        
                                from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                                    
                                    where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                            and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                            and contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
                                            and divers_sousrubrique_calendrier_paie_moe_detail.code='".$code."'
                        ) as id_prevu",FALSE);

        $this->db ->select("(select divers_calendrier_paie_moe_prevu.montant_prevu 
                                        
                        from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                            
                            where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                    and contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='".$code."'
                ) as montant_prevu",FALSE);
            
        $this->db ->select("(select facture_moe_entete.id 
                                        
                        from facture_moe_entete,contrat_bureau_etude 
                            
                            where contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                                    and contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
                                    and facture_moe_entete.validation=0 and facture_moe_entete.statu_fact=1
                ) as id_entete",FALSE);
         $this->db ->select("(select max(facture_moe_entete.numero) 
                                        
                from facture_moe_entete,contrat_bureau_etude 
                    
                    where contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                            and contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
                            and facture_moe_entete.validation IN(0,2)
        ) as num_max",FALSE);
        
        $this->db ->select("(select contrat_bureau_etude.id 
                                        
                from contrat_bureau_etude 
                    
                    where contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
        ) as id_contrat",FALSE);
                
    
        $result =  $this->db->from('convention_cisco_feffi_entete')
                            ->where('convention_cisco_feffi_entete.id',$id_convention_entete)
                            ->get()
                            ->result();
            if($result)
            {
                return $result;
            }else{
                return null;
            }                 
    }
    public function getfacturedetailbyconventionandcode($id_convention_entete,$code)
    {
        $this->db->select("convention_cisco_feffi_entete.id as id_conv");
    
        $this->db ->select("(select facture_moe_detail.id 
                                        
                                        from facture_moe_detail,facture_moe_entete,divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                                            
                                            where facture_moe_detail.id_calendrier_paie_moe_prevu=divers_calendrier_paie_moe_prevu.id 
                                                    and facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete 
                                                    and divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu 
                                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail
                                                    and contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                                                    and contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
                                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='".$code."'
                                                    and facture_moe_entete.validation IN(0,2)
                                ) as id_detail",FALSE);
        $this->db ->select("(select divers_calendrier_paie_moe_prevu.id 
                                        
                                from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                                    
                                    where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                            and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                            and contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
                                            and divers_sousrubrique_calendrier_paie_moe_detail.code='".$code."'
                        ) as id_prevu",FALSE);

        $this->db ->select("(select divers_calendrier_paie_moe_prevu.montant_prevu 
                                        
                        from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                            
                            where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                    and contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='".$code."'
                ) as montant_prevu",FALSE);
            
        $this->db ->select("(select facture_moe_entete.id 
                                        
                        from facture_moe_entete,contrat_bureau_etude 
                            
                            where contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                                    and contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
                                    and facture_moe_entete.validation=0 and facture_moe_entete.statu_fact=1
                ) as id_entete",FALSE);
         $this->db ->select("(select max(facture_moe_entete.numero) 
                                        
                from facture_moe_entete,contrat_bureau_etude 
                    
                    where contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                            and contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
                            and facture_moe_entete.validation IN(0,2)
        ) as num_max",FALSE);
        
        $this->db ->select("(select contrat_bureau_etude.id 
                                        
                from contrat_bureau_etude 
                    
                    where contrat_bureau_etude.id_convention_entete='".$id_convention_entete."'
        ) as id_contrat",FALSE);
                
    
        $result =  $this->db->from('convention_cisco_feffi_entete')
                            ->where('convention_cisco_feffi_entete.id',$id_convention_entete)
                            ->get()
                            ->result();
            if($result)
            {
                return $result;
            }else{
                return null;
            }                 
    }

    public function getfacturedetailp5p6supprbyconventionandcode($id_convention_entete)
    {
        $this->db->select("convention_cisco_feffi_entete.id as id_conv");
    
        $this->db ->select("(select facture_moe_detail.id 
                                        
                                        from facture_moe_detail,facture_moe_entete,divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                                            
                                            where facture_moe_detail.id_calendrier_paie_moe_prevu=divers_calendrier_paie_moe_prevu.id 
                                                    and facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete 
                                                    and divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu 
                                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail
                                                    and contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                                                    and contrat_bureau_etude.id_convention_entete=id_conv
                                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='p5'
                                                    and facture_moe_entete.validation=0 and statu_fact=1
                                ) as id_detail_p5",FALSE);

        $this->db ->select("(select facture_moe_detail.id

                                from facture_moe_detail,facture_moe_entete,divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                                    
                                    where facture_moe_detail.id_calendrier_paie_moe_prevu=divers_calendrier_paie_moe_prevu.id 
                                            and facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete 
                                            and divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu 
                                            and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail
                                            and contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                                            and contrat_bureau_etude.id_convention_entete=id_conv
                                            and divers_sousrubrique_calendrier_paie_moe_detail.code='p6'
                                            and facture_moe_entete.validation=0 and statu_fact=1
                        ) as id_detail_p6",FALSE);
        $this->db ->select("(select divers_calendrier_paie_moe_prevu.id 
                                        
                                from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                                    
                                    where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                            and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                            and contrat_bureau_etude.id_convention_entete=id_conv
                                            and divers_sousrubrique_calendrier_paie_moe_detail.code='p5'
                        ) as id_prevu_p5",FALSE);
        
        $this->db ->select("(select divers_calendrier_paie_moe_prevu.id 
                                        
                        from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                            
                            where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                    and contrat_bureau_etude.id_convention_entete=id_conv
                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='p6'
                ) as id_prevu_p6",FALSE);

        $this->db ->select("(select divers_calendrier_paie_moe_prevu.montant_prevu 
                                        
                        from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                            
                            where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                    and contrat_bureau_etude.id_convention_entete=id_conv
                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='p5'
                ) as montant_prevu_p5",FALSE);

        $this->db ->select("(select divers_calendrier_paie_moe_prevu.montant_prevu 
                                        
                        from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                            
                            where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                    and contrat_bureau_etude.id_convention_entete=id_conv
                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='p6'
                ) as montant_prevu_p6",FALSE);
            
        $this->db ->select("(select facture_moe_entete.id 
                                        
                        from facture_moe_entete,contrat_bureau_etude 
                            
                            where contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                                    and contrat_bureau_etude.id_convention_entete=id_conv
                                    and facture_moe_entete.validation=0 and statu_fact=1
                ) as id_entete",FALSE);
         $this->db ->select("(select max(facture_moe_entete.numero) 
                                        
                from facture_moe_entete,contrat_bureau_etude 
                    
                    where contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                            and contrat_bureau_etude.id_convention_entete=id_conv
                            and facture_moe_entete.validation IN(0,2)
        ) as num_max",FALSE);
        
        $this->db ->select("(select contrat_bureau_etude.id 
                                        
                from contrat_bureau_etude 
                    
                    where contrat_bureau_etude.id_convention_entete=id_conv
        ) as id_contrat",FALSE);
                
    
        $result =  $this->db->from('convention_cisco_feffi_entete')
                            ->where('convention_cisco_feffi_entete.id',$id_convention_entete)
                            ->get()
                            ->result();
            if($result)
            {
                return $result;
            }else{
                return null;
            }                 
    }
    public function getfacturedetailp5p6byconventionandcode($id_convention_entete)
    {
        $this->db->select("convention_cisco_feffi_entete.id as id_conv");
    
        $this->db ->select("(select facture_moe_detail.id 
                                        
                                        from facture_moe_detail,facture_moe_entete,divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                                            
                                            where facture_moe_detail.id_calendrier_paie_moe_prevu=divers_calendrier_paie_moe_prevu.id 
                                                    and facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete 
                                                    and divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu 
                                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail
                                                    and contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                                                    and contrat_bureau_etude.id_convention_entete=id_conv
                                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='p5'
                                                    and facture_moe_entete.validation IN(0,2)
                                ) as id_detail_p5",FALSE);

        $this->db ->select("(select facture_moe_detail.id

                                from facture_moe_detail,facture_moe_entete,divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                                    
                                    where facture_moe_detail.id_calendrier_paie_moe_prevu=divers_calendrier_paie_moe_prevu.id 
                                            and facture_moe_entete.id=facture_moe_detail.id_facture_moe_entete 
                                            and divers_calendrier_paie_moe_prevu.id=facture_moe_detail.id_calendrier_paie_moe_prevu 
                                            and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail
                                            and contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                                            and contrat_bureau_etude.id_convention_entete=id_conv
                                            and divers_sousrubrique_calendrier_paie_moe_detail.code='p6'
                                            and facture_moe_entete.validation IN(0,2)
                        ) as id_detail_p6",FALSE);
        $this->db ->select("(select divers_calendrier_paie_moe_prevu.id 
                                        
                                from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                                    
                                    where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                            and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                            and contrat_bureau_etude.id_convention_entete=id_conv
                                            and divers_sousrubrique_calendrier_paie_moe_detail.code='p5'
                        ) as id_prevu_p5",FALSE);
        
        $this->db ->select("(select divers_calendrier_paie_moe_prevu.id 
                                        
                        from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                            
                            where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                    and contrat_bureau_etude.id_convention_entete=id_conv
                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='p6'
                ) as id_prevu_p6",FALSE);

        $this->db ->select("(select divers_calendrier_paie_moe_prevu.montant_prevu 
                                        
                        from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                            
                            where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                    and contrat_bureau_etude.id_convention_entete=id_conv
                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='p5'
                ) as montant_prevu_p5",FALSE);

        $this->db ->select("(select divers_calendrier_paie_moe_prevu.montant_prevu 
                                        
                        from divers_calendrier_paie_moe_prevu,contrat_bureau_etude,divers_sousrubrique_calendrier_paie_moe_detail 
                            
                            where contrat_bureau_etude.id=divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude 
                                    and divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail  
                                    and contrat_bureau_etude.id_convention_entete=id_conv
                                    and divers_sousrubrique_calendrier_paie_moe_detail.code='p6'
                ) as montant_prevu_p6",FALSE);
            
        $this->db ->select("(select facture_moe_entete.id 
                                        
                        from facture_moe_entete,contrat_bureau_etude 
                            
                            where contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                                    and contrat_bureau_etude.id_convention_entete=id_conv
                                    and facture_moe_entete.validation=0 and statu_fact=1
                ) as id_entete",FALSE);
         $this->db ->select("(select max(facture_moe_entete.numero) 
                                        
                from facture_moe_entete,contrat_bureau_etude 
                    
                    where contrat_bureau_etude.id=facture_moe_entete.id_contrat_bureau_etude  
                            and contrat_bureau_etude.id_convention_entete=id_conv
                            and facture_moe_entete.validation IN(0,2)
        ) as num_max",FALSE);
        
        $this->db ->select("(select contrat_bureau_etude.id 
                                        
                from contrat_bureau_etude 
                    
                    where contrat_bureau_etude.id_convention_entete=id_conv
        ) as id_contrat",FALSE);
                
    
        $result =  $this->db->from('convention_cisco_feffi_entete')
                            ->where('convention_cisco_feffi_entete.id',$id_convention_entete)
                            ->get()
                            ->result();
            if($result)
            {
                return $result;
            }else{
                return null;
            }                 
    }
/*

    public function getfacture_moe_detailwithcalendrier_detailbyentete($id_contrat_bureau_etude,$id_facture_moe_entete,$id_sousrubrique)
    {
       $this->db->select("
            divers_sousrubrique_calendrier_paie_moe_detail.id as id_sousrubrique_detail,
            divers_sousrubrique_calendrier_paie_moe_detail.libelle as libelle,
            divers_sousrubrique_calendrier_paie_moe_detail.code as code,
            divers_sousrubrique_calendrier_paie_moe_detail.pourcentage as pourcentage,
            divers_calendrier_paie_moe_prevu.montant_prevu as montant_prevu");
       $this->db ->select("((
                select fact_detail.id 
                        
                        from facture_moe_detail as fact_detail 

                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." 
                                and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." 
                                and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                and sousrubrique_calendrier_detail.id=id_sousrubrique_detail)) as id",false);
       $this->db ->select("((
                select fact_detail.observation 
                        
                        from facture_moe_detail as fact_detail 

                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." 
                                and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." 
                                and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                and sousrubrique_calendrier_detail.id=id_sousrubrique_detail)) as observation",false);

            $this->db ->select("((
                select fact_detail.montant_periode 
                        
                        from facture_moe_detail as fact_detail 

                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." 
                                and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." 
                                and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                and sousrubrique_calendrier_detail.id=id_sousrubrique_detail)) as montant_periode",false);
            $this->db ->select("((
                select sum(fact_detail.montant_periode) 
                        
                        from facture_moe_detail as fact_detail 

                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        inner join facture_moe_entete as fact_entete on fact_entete.id=fact_detail.id_facture_moe_entete
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude."  
                                and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                and sousrubrique_calendrier_detail.id=id_sousrubrique_detail
                                and fact_entete.id<".$id_facture_moe_entete." and fact_entete.validation=4)) as montant_anterieur",false);

            $this->db ->select("((
                select 
                        sum(detail.montant_anterieur)+sum(detail.montant_periode)

                    from
                        (
                        select  
                                fact_detail.montant_periode as montant_periode,
                                0 as montant_anterieur 

                            from facture_moe_detail as fact_detail 

                                inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                                inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                    
                                where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." 
                                        and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." 
                                        and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                        and sousrubrique_calendrier_detail.id=id_sousrubrique_detail 
                        UNION

                        select 
                                0 as montant_periode,
                                sum(fact_detail.montant_periode) as montant_anterieur  

                            from facture_moe_detail as fact_detail 

                                inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                                inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                                inner join facture_moe_entete as fact_entete on fact_entete.id=fact_detail.id_facture_moe_entete
                    
                                where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude."  
                                        and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                        and sousrubrique_calendrier_detail.id=id_sousrubrique_detail
                                        and fact_entete.id<".$id_facture_moe_entete." 
                                        and fact_entete.validation=4) detail
                        )) as montant_cumul",false);
            $this->db ->select("((
                select 
                        (sum(fact_detail.montant_periode)*100)/montant_prevu

                        from facture_moe_detail as fact_detail 

                            inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                            inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                            inner join facture_moe_entete as fact_entete on fact_entete.id=fact_detail.id_facture_moe_entete
                
                            where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude."  
                                    and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                    and sousrubrique_calendrier_detail.id=id_sousrubrique_detail
                                    and fact_entete.id<".$id_facture_moe_entete." and fact_entete.validation=4

                    
                        )) as pourcentage_anterieur",false);
            $this->db ->select("((
                select 
                        (fact_detail.montant_periode*100)/montant_prevu

                        from facture_moe_detail as fact_detail 

                            inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                            inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                    
                            where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." 
                                        and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." 
                                        and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                        and sousrubrique_calendrier_detail.id=id_sousrubrique_detail

                    
                        )) as pourcentage_periode",false);
            $this->db ->select("((
                select 
                        ((sum(detail.montant_anterieur)+sum(detail.montant_periode))*100)/montant_prevu

                    from
                        (
                        select  
                                fact_detail.montant_periode as montant_periode,
                                0 as montant_anterieur 

                            from facture_moe_detail as fact_detail 

                                inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                                inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                    
                                where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." 
                                        and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." 
                                        and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                        and sousrubrique_calendrier_detail.id=id_sousrubrique_detail 
                        UNION

                        select 
                                0 as montant_periode,
                                sum(fact_detail.montant_periode) as montant_anterieur  

                            from facture_moe_detail as fact_detail 

                                inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                                inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                                inner join facture_moe_entete as fact_entete on fact_entete.id=fact_detail.id_facture_moe_entete
                    
                                where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude."  
                                        and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
                                        and sousrubrique_calendrier_detail.id=id_sousrubrique_detail
                                        and fact_entete.id<".$id_facture_moe_entete." 
                                        and fact_entete.validation=4) detail
                        )) as pourcentage_cumul",false);

       

        $result =  $this->db->from('divers_sousrubrique_calendrier_paie_moe_detail,divers_calendrier_paie_moe_prevu')
                    
                    ->where('divers_sousrubrique_calendrier_paie_moe_detail.id = divers_calendrier_paie_moe_prevu.id_sousrubrique_detail')
                    ->where('id_contrat_bureau_etude',$id_contrat_bureau_etude)
                   
                    ->where('id_sousrubrique',$id_sousrubrique)
                    ->group_by('id_sousrubrique_detail')
                                       
                    ->get()
                    ->result();                              

        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/

   


}
