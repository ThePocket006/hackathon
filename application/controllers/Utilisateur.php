<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateur extends MY_Controller {

    function __construct(){
        parent::__construct();

        $this->zone = 'utilisateurs';
		$this->load->model('user/U_Model');
        $this->load->model('Capacity_model','mCap');
        $this->load->model('User_model','mUs');
        $this->load->helper('general');
        $this->load->library('form_validation');

    }

    public function  index()
    {
        $this->render('index', translate('Configuration des utilisateurs', 'configure users'));
    }

    public function addRole()
    {
        $this->data['categories'] = $categories = $this->mSet->selectTableCriterion('*','ci_category','id != 0');
        $caps = array();
        foreach($categories  as $category){
            $capacites = $this->mSet->selectTableCriterion('*','ci_capacity','category ='.$category->id);
            foreach($capacites as $capacite){
                $caps[$category->id][] = $capacite;
            }
        }
        $this->data['caps'] = $caps;
        $capacities = $this->mSet->selectTableCriterion('*','ci_capacity','id != 0');
        if(isset($_POST['save'])){

            $saveRole = array('nom'=>$this->input->post('role'));
            $role = $this->mSet->saveTable($saveRole,'role');

            foreach($capacities as $capacity){
                if(isset($_POST['check'.$capacity->id])){

                    $saveCapaciteRole = array(
                                       'capacite'=>$capacity->id,
                                       'role'=>$role
                                   );
                   $this->mSet->saveTable($saveCapaciteRole,'ci_capacity_role');
                }
            }
            $this->session->set_tempdata('success', 'Le Profil a été ajouté avec succès');
            redirect('Utilisateur/listRole');

        }
        $this->render('save_role', translate('Ajouter un role', 'Add a role'));
    }
  
    public function listRole()
    {
        $roles = $this->mSet->selectTableCriterion('*','role','id != 0');//on veut tous les roles
        $caps = array();
        foreach($roles as $role){
            $capacites = $this->mCap->getCapacitiesRole($role->id);
            foreach($capacites as $capacite){
                $caps[$role->id][] = $capacite->name;
            }
        }
        $this->data['roles'] = $roles;
        $this->data['caps'] = $caps;
        $this->render('list_role', translate('Liste des roles', 'Roles list'));
    }

    public function addGroup()
    {
        $parentGroup = $this->mSet->selectTableCriterion('*','ci_group', 'groupe_lie =' . null);//on veut tous les roles
        if(isset($_POST['save'])) {
            $nombreChamp = $this->input->post('nombreChamp');
            if (intval($nombreChamp) != 0) {
                for ($i = 0; $i < intval($nombreChamp); $i++) {
                    $k = $i + 1;
                    if (isset($_POST['groupe_' . $k])) {
                        $data = array(
                            'name'=>$_POST['groupe_' . $k],
                            'creation_date'=>moment()->format('Y-m-d H:i:s'),
                            'groupe_lie'=>$parentGroup[0]->id
                        );
                        $groupe = $this->mSet->saveTable($data,'ci_group');


                    }
                }
            }
            $this->session->set_tempdata('success', 'opération réalisé avec avec succès');
            redirect('Utilisateur/listGroup');
        }

        $this->render('add_group', translate('Ajouter un service central ou établissement', 'Add a group'));
    }

    public function  addSousGroup()
    {
        $this->data['groupes'] = $this->mSet->selectTableCriterion('*','ci_group', 'id != 0');
        if(isset($_POST['save'])) {
            $nombreChamp = $this->input->post('nombreChamp');


            if (intval($nombreChamp) != 0) {

                for ($i = 0; $i < intval($nombreChamp); $i++) {
                    $k = $i + 1;
                    if (isset($_POST['sgroupe_' . $k])) {
                        $data = array(
                            'nom'=>$_POST['sgroupe_' . $k],
                            'groupe'=>$_POST['groupe'],
                            'creation_date'=>moment()->format('Y-m-d H:i:s')
                        );
                        $sgroupe = $this->mSet->saveTable($data,'ci_sous_groupe');


                    }
                }

            }
            $this->session->set_tempdata('success', 'opération réalisé avec avec succès');
            redirect('Utilisateur/listGroup');

        }
        $this->render('add_sous_group', translate('Ajouter un sous groupe', 'Add a sous group'));

    }

    public function  displaySgroupofGroup()
    {
      $groupe = $_POST['groupe'];
      $this->data['sgroupes'] = $this->mSet->selectTableCriterion('*','ci_sous_groupe', 'groupe ='.$groupe,'nom','ASC');
        $this->execute('display_sgroup_of_group');
    }

    public function  newUser()
    {

        $this->data['groupes'] = $this->mSet->selectTableCriterion('*','ci_group', 'id != 0','name','ASC');
        if(isGeneralAdmin())
             $this->data['roles'] = $this->mSet->selectTableCriterion('*','role', 'id != 0','nom','ASC');
        else
            $this->data['roles'] = $this->mSet->selectTableCriterion('*','role', 'visible_everywhere = 1','nom','ASC');
        if(isset($_POST['save'])){
            $lastIndex = $this->mSet->selectTableCriterion('max(id) as id','ci_user','id!=0');
            $pass = "un@" . castNumberId($lastIndex[0]->id + 1, 5);
                $saveData = array(
                    'login' => $this->input->post('Ulogin'),
                    'pwd' => sha1($pass),
                    'name' => $this->input->post('Uname'),
                    'email' => $this->input->post('Umail'),
                    'groupe' => $this->input->post('groupe'),
                    's_groupe' => ($this->input->post('sgroupe') == 'none') ? NULL : $this->input->post('sgroupe'),
                    'role' => isset($_POST['role'])?$_POST['role']:ROLE_SIMPLE_USER,
                    'register_date'=>moment()->format('Y-m-d H:i:s')

                );
                $user = $this->mSet->saveTable($saveData, 'ci_user');
                $handle1 = fopen('./assets/documents/pass.txt', 'a');
                $texte = "\n".$user."-".$pass;
                fwrite($handle1,$texte);
                fclose($handle1);
                //$this->notify('Enregistrement réussi');
                $this->session->set_tempdata('success', 'Enregistrement réussi');
                redirect('Utilisateur/listUsers');

        }
        $this->render('add_user', translate('Ajouter un utilisateur', 'Add a user'));
    }
    public function  listGroup($action = NULL , $groupe = NULL)
    {
        $this->data['groupes'] = $this->mSet->selectTableCriterion('*','ci_group','id != 0');
        if($action != NULL){
            if($action == 'locked'){
                $dataG['status'] = GROUPE_BLOQUE;
                $dataSG['status'] = SGROUPE_BLOQUE;
                $dataU['status'] = COMPTE_BLOQUE;
            }else{
                $dataG['status'] = GROUPE_ACTIF;
                $dataSG['status'] = SGROUPE_ACTIF.
                    $dataU['status'] = COMPTE_ACTIF;
            }
            $this->mSet->updateTableCriterion($dataG,'ci_group',"id = $groupe");
            $this->mSet->updateTableCriterion($dataSG,'ci_sous_groupe',"groupe = $groupe");
            $this->mSet->updateTableCriterion($dataU,'ci_user',"groupe = $groupe");
            $this->session->set_tempdata('success', 'Opération réussie');
            redirect('Utilisateur/listGroup');

        }
        $this->render('list_group', translate('Liste des groupes', 'Groups List'));
    }
    public function  listSousGroupe($groupe,$action = NULL , $sgroupe  = NULL)
    {
        $this->data['s_groupes'] = $this->mSet->selectTableCriterion('*','ci_sous_groupe',"groupe = $groupe",'nom','ASC');
        $this->data['groupeN'] = $this->mSet->selectTableCriterion('*','ci_group',"id = $groupe")[0];
        if($action != NULL){
            if($action == 'locked'){
                $dataSG['status'] = SGROUPE_BLOQUE;
                $dataU['status'] = COMPTE_BLOQUE;
            }else{
                $dataSG['status'] = SGROUPE_ACTIF.
                    $dataU['status'] = COMPTE_ACTIF;
            }
            $this->mSet->updateTableCriterion($dataSG,'ci_sous_groupe',"id = $sgroupe");
            $this->mSet->updateTableCriterion($dataU,'ci_user',"s_groupe = $sgroupe");
            $this->session->set_tempdata('success', 'Opération réussie');
            redirect('Utilisateur/listSousGroupe/'.$groupe);

        }
        $this->render('list_sous_group', translate('Liste des  sous groupes', 'SGroups List'));
    }
    public function  listUsers($action = NULL , $user = NULL)
    {
        $this->data['groupes'] = $this->mSet->selectTableCriterion('*','ci_group', 'id != 0','name','ASC');
        if(isGeneralAdmin())
            $this->data['users'] = $this->mUs->allUsers();
        elseif(isChefDepartement())
            $this->data['users'] = $this->mUs->allUsers(session_data('groupId'),session_data('sgroupId'));
        else{

            $this->data['users'] = $this->mUs->allUsers(session_data('groupId'),session_data('sgroupId'),true);
        }

        if($action != NULL){
            if($action == 'locked')
                $data['status'] = COMPTE_BLOQUE;
            else
                $data['status'] = COMPTE_ACTIF;
            $this->mSet->updateTableCriterion($data,'ci_user',"id = $user");
            $this->session->set_tempdata('success', 'Opération réussie');
            redirect('Utilisateur/listUsers');

        }

        $this->render('list_user', translate('Liste des utilisateurs', 'User List'));
    }

    public function  usersGroupSgroup()
    {
        $grp = $_POST['groupe'];
        $sgrp = $_POST['sgroupe'];
        if($sgrp == 'none') $sgrp = NULL;
        $this->data['users'] = $this->mUs->allUsers($grp,$sgrp);
        $this->execute('display_users_grp_sgrp');

    }

    public function  usersGroupSgroupPass()
    {

        $grp = $_POST['groupe'];
        $sgrp = $_POST['sgroupe'];
        if($sgrp == 'none') $sgrp = NULL;
        $this->data['users'] = $this->mUs->allUsers($grp,$sgrp);
        $tableaux = array();
        $pass = array();
        $handle = fopen("./assets/documents/pass.txt", "r" );
        if ($handle)
        {
            while (!feof($handle))
            {
                $buffer = fgets($handle, 4096);
                $tableaux[] = $buffer;
            }
            fclose($handle);
        }
        foreach($tableaux as $tableau){
            $info = explode('-',$tableau);
            $pass[$info[0]] = isset($info[1]) ? $info[1] : '';

        }

        $this->data['pass'] = $pass;
        $this->execute('display_users_grp_sgrp_pass');

    }

    public function  editRole($role)
    {
        $this->data['role'] = $this->mSet->selectTableCriterion('*','role', "id = $role");
        $capacitiesOfRole = $this->mSet->selectTableCriterion('*','ci_capacity_role', "role = $role");
        $this->data['capacitiesOfRole'] = array();
        foreach($capacitiesOfRole as $capacityOfRole){
            $this->data['capacitiesOfRole'][] = $capacityOfRole->capacite;
        }
        $this->data['categories'] = $categories = $this->mSet->selectTableCriterion('*','ci_category','id != 0');
        $caps = array();
        foreach($categories  as $category){
            $capacites = $this->mSet->selectTableCriterion('*','ci_capacity','category ='.$category->id);
            foreach($capacites as $capacite){
                $caps[$category->id][] = $capacite;
            }
        }
        $this->data['caps'] = $caps;
        $capacities = $this->mSet->selectTableCriterion('*','ci_capacity','id != 0');
        if(isset($_POST['edit'])){

            $updateRole = array(
                'nom'=>$this->input->post('role'),
                'visible_everywhere'=>$this->input->post('visible')
            );
            $this->mSet->updateTableCriterion($updateRole,'role' , "id = $role");
            $this->mSet->deleteTableCriterion('ci_capacity_role',"role = $role");
            foreach($capacities as $capacity){
                if(isset($_POST['check'.$capacity->id])){

                    $saveCapaciteRole = array(
                        'capacite'=>$capacity->id,
                        'role'=>$role
                    );
                    $this->mSet->saveTable($saveCapaciteRole,'ci_capacity_role');
                }
            }
            $this->session->set_tempdata('success', 'Opération réussie');
            redirect('Utilisateur/listRole');

        }

        $this->render('edit_role', translate('Modifier un role', 'Edit a role'));
    }

    public function  profile()
    {

        $this->form_validation->set_error_delimiters('<p class="form_erreur text-danger small">', '<p>');
        $this->form_validation->set_rules('oldP', 'Ancien mot de passe', 'trim|required|min_length[1]|max_length[64]|encode_php_tags');
        $this->form_validation->set_rules('newP', 'Nouveau mot de passe', 'trim|required|min_length[1]|max_length[64]|encode_php_tags|differs[oldP]');
        $this->form_validation->set_rules('rP', 'Confirmer mot de passe', 'trim|required|min_length[1]|max_length[64]|encode_php_tags|matches[newP]');

        if($this->form_validation->run())
        {
            $oldPass =  $this->mSet->selectTableCriterion('*','ci_user',array('id'=>session_data('id')));
            if($oldPass[0]->pwd != sha1($this->input->post('oldP'))){
                $this->data['error'] = "L'ancien mot de passe entré est érroné";
            }else{
                $this->mSet->updateTableCriterion(array('pwd'=>sha1($this->input->post('newP'))) ,'ci_user',array('id'=>session_data('id')));
                $this->session->set_tempdata('success', 'Opération réussie');
                redirect('home');
            }

        }else{
            if(!empty(validation_errors()))
                $this->data['error'] = validation_errors();
        }
        $this->render('profile', translate('Mon profil', 'My profile'));
    }

    public function  checkIfModifyPwd()
    {
        $actualUrl = $_POST['url'];
        if($actualUrl != '/uncourriers/index.php/utilisateur/profile' && $actualUrl != site_url('utilisateur/login')){
            $check = $this->mSet->selectTableCriterion('*','ci_user','id = '.session_data('id'))[0];
            if($check->pwd == sha1(DEFAULT_PASSWORD))
                echo 0;
            else
                echo 1;
        }else{
            echo 1;
        }
    }

    public function  modifyProfil()
    {
       
        $this->form_validation->set_error_delimiters('<p class="form_erreur text-danger small">', '<p>');
        $this->form_validation->set_rules('nom', 'Noms et prenoms', 'trim|required|min_length[10]|encode_php_tags');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[64]|encode_php_tags');

        if($this->form_validation->run())
        {
            // var_dump($_FILES['photo']["name"]);die;
            if(!empty($_FILES['photo']["name"]))
            {
                $nom = $_FILES['photo']['name'];
            $ext = explode(".", $nom);
            $ext = end($ext);
            $nom = randomPassword(25);
            $nom = $nom . "." . $ext;
            $chemin = asset_path('images/profil') . "/" . $nom;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $chemin)) {
                $this->mSet->updateTableCriterion(array('name'=>$this->input->post('nom'), 'email'=>$this->input->post('email'),'photo'=>$nom) ,'ci_user',array('id'=>session_data('id')));
               
                $_SESSION['name']=$this->input->post('nom');
                $_SESSION['email']=$this->input->post('email');
                $_SESSION['photo']=$nom;
               
                $this->session->set_tempdata('success', 'Opération réussie');
                redirect('utilisateur/profile');
            } else {
                $this->data['error'] = " erreur d'enregistrement de l'image " . $_FILES['photo']['name'];
            }


            }else{
                $this->mSet->updateTableCriterion(array('name'=>$this->input->post('nom'), 'email'=>$this->input->post('email')) ,'ci_user',array('id'=>session_data('id')));
               
                $_SESSION['name']=$this->input->post('nom');
                $_SESSION['email']=$this->input->post('email');
               
                $this->session->set_tempdata('success', 'Opération réussie');
                redirect('utilisateur/profile');
            }


        }else{
            if(!empty(validation_errors()))
                $this->data['error'] = validation_errors();
        }
        $this->render('profile', translate('Mon profil', 'My profile'));
    }

    public function  generatePass()
    {
        $pass = array();
        $tableaux = array();
        $handle = fopen("./assets/documents/pass.txt", "r" );
        if ($handle)
        {
            while (!feof($handle))
            {
                $buffer = fgets($handle, 4096);
                $tableaux[] = $buffer;
            }
            fclose($handle);
        }
        foreach($tableaux as $tableau){
            $info = explode('-',$tableau);
            $pass[$info[0]] = isset($info[1]) ? $info[1] : '';

        }

        $this->data['pass'] = $pass;
        $this->data['groupes'] = $this->mSet->selectTableCriterion('*','ci_group', 'id != 0','name','ASC');
        $this->data['users'] = $this->mUs->allUsers();
        $this->render('generate_pass', translate('Liste des utilisateurs avec mot de passe', 'User List'));

    }

}