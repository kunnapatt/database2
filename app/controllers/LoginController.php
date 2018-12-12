<?php
    // use Phalcon\Flash\Direct as Flash;
    // use Phalcon\Flash\Session as Flash;

    class LoginController extends ControllerBase {
        public function indexAction() {
            if( $this->session->has('sid') ){
                return $this->response->redirect("index") ;
            }else{
                if( $this->request->isPost() ){
                    
                    $username = $this->request->getPost("usernamelogin") ;
                    $password = $this->request->getPost("passwordlogin") ;
                    $userlogin = Customers::findFirst("username = '$username'") ;

                    if ( $userlogin !=  null ){
                    if ( $userlogin->username == $username ){

                        if ( $userlogin->password == $password ){
                            $this->flash->success("Login Correcct ") ;
                            $id = $userlogin->cid ;
                            $this->cookies->set("id", $userlogin->cid, time() + 86400) ;
                            $this->view->usernamelogin = $username ;
                            $this->view->passwordlogin = $password ;
                            $this->session->set('sid', "$id") ;
                            $this->response->redirect("index") ;
                        }
                    }else{
                        $this->flashSession->error("username or password incorrect") ;
                    }
                }else{
                    // $this->response->redirect("login/index") ;
                    var_dump("Don't have user") ;
                    $this->flashSession->error("username incorrect") ;
                    // exit() ;
                    } 
                }
            }
        }
        public function registerAction(){
            if ( $this->request->isPost() ){
                $usernamel = $this->request->getPost("username") ;
                $passwordl = $this->request->getPost("password") ;
                $email = $this->request->getPost("email") ;
                $pnumber = $this->request->getPost("pnumber") ;
                $fname = $this->request->getPost("fname") ;
                $lname = $this->request->getPost("lname") ;
                $gender = $this->request->getPost("gender") ;
                $dob = $this->request->getPost("dob") ;
                $homeadd = $this->request->getPost("homeadd") ;
                $workadd = $this->request->getPost("workadd") ;              
                $cid = (string)rand(100000,999999);
                $balance = 0;

                $this->response->redirect('login') ;
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "mydb";
                $conn = new mysqli($servername, $username, $password, $dbname);
    
                $sql = "INSERT INTO customers VALUES ('$cid','$fname','$lname','$dob','$gender','$pnumber','$homeadd','$workadd','$usernamel','$passwordl','$email','$balance')";
                $conn->query($sql);

                $of = DeptTrackers::findFirst()->oid;
                $sql = "INSERT INTO tracking VALUES ('$of','$cid')";
                $conn->query($sql);
                }    
            }

        public function logoutAction(){
            $dele = $this->cookies->get("id") ;
            $dele->delete() ;
            $this->session->destroy() ;

            $this->response->redirect("index") ;
        }

    }
?>