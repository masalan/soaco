<?php

class Company extends Base_Model
{

    protected $table_name;

    function __construct()
    {
        parent::__construct();
        $this->table_name = 'cd_company';
    }





    /** GET Company Infos
     * @param $id
     * @return mixed
     */
    public function get_company_info($id)
    {$this->db->select('
    be_users.user_id,
    be_users.rccm,
    be_users.ifu,
    be_users.idus,
    be_users.fullname,
    be_users.owner_name,
    be_users.cat_id,
    be_users.sub_cat_id,
    be_users.twon_id,
    be_users.address,
    be_users.lat,
    be_users.is_published,
    be_users.`status`,
    be_users.search_tag,
    be_users.contactes,
    be_users.company_phone,
    be_users.nosServices,
    be_users.lng,
    be_users.logo,
    be_users.profile_photo,
    be_users.about_me,
    be_users.is_city_admin,
    be_users.is_owner,
    be_users.role_id,
    be_users.user_pass,
    be_users.user_email,
    be_users.phone,
    be_users.answer,
    be_users.question,
    be_users.mother,
    be_users.father,
    be_users.user_name,
    be_users.company_id,
    be_users.is_gerant,
    be_users.arrondissement_id,
    be_users.city_id,
    be_users.station_id,
    cd_licence.is_live,
    cd_licence.licence_updated,
    cd_licence.licence_created,
    cd_licence.licence_end_time,
    cd_licence.licence_start_time,
    cd_licence.licence_name,
    cd_licence.licence_admin_id,
    cd_licence.licence_idus,
    cd_licence.licence_company_id');
        $this->db->from('be_users');
        $this->db->join('cd_licence ','be_users.user_id = cd_licence.licence_company_id','ON');
        if($id){
            $this->db->where(array('be_users.user_id'=>$id,'be_users.is_gerant'=>2));
        }else{
            $this->db->where(array('be_users.user_id'=>$id));
            $this->db->where('be_users.country_id',$this->session->userdata('country_id'));  // by country

        }
        return $this->db->get()->row();
    }




    /** Vente Journalier
     * de chaque Produit
     * @param $type
     * @return mixed
     */

    function vente_par_jour($type,$station_id)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->select_sum('quantity_out');
        $this->db->where('type', $type);
        $this->db->where('status', 1);
        $this->db->where('is_oil',0);
        $this->db->where('DATE(time_out)',$curr_date);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('station_id', $station_id);

        $query = $this->db->get('cd_fluid_log');
        return $query;
    }
















    function is_paypal_enable()
    {
        $query = $this->db->get_where( $this->table_name, array( 'status' => 1 ));
        return ( $query->num_rows() > 0 );
    }

    function save( $data )
    {
        return $this->db->update( $this->table_name, $data );
    }

    function get()
    {
        $query = $this->db->get_where( $this->table_name, array( 'status' => 1 ));
        return $query->row();
    }

    function get_paypal_config()
    {
        $query = $this->db->get_where( $this->table_name );
        return $query->row();
    }
}
?>