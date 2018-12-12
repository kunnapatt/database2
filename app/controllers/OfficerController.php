<?php
    class OfficerController extends ControllerBase {
        public function indexAction(){
            if ( $this->session->has('id') ){
                // var_dump("Me la na") ;
                // exit() ;
                // $this->session->destroy() ;

            }else{
                $this->response->redirect("index") ;
            }
        }

        public function loginAction() {
            if ( $this->session->has('id') == null ) {
                if ( $this->request->isPost() ){
                    $id = $this->request->getPost("id") ;
                    $pass = $this->request->getPost("pass") ;

                    $officer = Officers::findFirst("username = '$id'") ;

                    if ( $officer->username != null ){
                        if ( $officer->username == $id ) {
                            if ( $officer->pass == $pass ) { 
                                $this->cookies->set("id", $officer->oid , time()+86400 ) ;
                                $this->session->set('id', "$officer->oid") ;
                                $this->response->redirect("officer/index") ;
                            }
                        }
                    }
                }
            } else {
                $this->response->redirect('index') ;
            }
        }

        public function logoutAction() {
            $this->session->destroy() ;

            $this->response->redirect('index') ;

        }

        public function customerAction() {
            if ( $this->session->has('id') != null ) {
                $user = Customers::find() ;

                foreach ( $user as $a ){
                    $b[] = $a->toArray() ;
                }
                foreach ( $b as $c ){
                    $cid[] = $c['cid'] ;

                }
                $this->view->cid = $cid ;

                if ( $_GET['id'] ){
                    $id = $_GET['id'] ;
                }else {
                    $id = "" ;
                }

                if ( $id ) {
                    $cus = Customers::findFirst("cid = $id") ;

                    $cid = $cus->cid ;
                    $fname = $cus->fname ;
                    $sname = $cus->sname ;
                    $dob = $cus->DOB;
                    $pnum = $cus->pnumber ;
                    $address = $cus->homeaddress ;
                    $work = $cus->workaddress ;
                    $email = $cus->email ;
                    $balance = $cus->balance ;
        
                    $this->view->id = $cid ;
                    $this->view->fname = $fname ;
                    $this->view->sname = $sname ;
                    $this->view->dob = $dob ;
                    $this->view->pnum = $pnum ;
                    $this->view->address = $address ;
                    $this->view->work = $work ;
                    $this->view->email = $email ;
                    $this->view->balance = $balance ;


                    if ( $this->request->isPost() ) {
                        
                        $name = $this->request->getPost("name") ;
                        $surname = $this->request->getPost("surname") ;
                        $dateof = $this->request->getPost("dateof") ;
                        $mail = $this->request->getPost("mail") ;
                        $phone = $this->request->getPost("phone") ;
                        $home = $this->request->getPost("home") ;
                        $workat = $this->request->getPost("workat") ;
                        $addsub = $this->request->getPost("addsub1") ;
                        
                        $calbalance = $balance + $addsub ;  

                        $cus->fname = $name ;
                        $cus->sname = $surname ;
                        $cus->dob = $dateof;
                        $cus->email =$mail ;
                        $cus->pnumber = $phone ;
                        $cus->homeaddress = $home ;
                        $cus->workaddress = $workat ;
                        $cus->balance = $calbalance ;

                        $cus->save() ;

                        $this->response->redirect('officer/customer&id=') ;
                    }
                }
                
            } else {
                $this->response->redirect("index") ;
            }
        }

        public function deptAction() {
            if ( $this->session->has('id') != null ){
                $id = $this->session->get('id') ;
                $officer = Officers::findFirst("oid = '$id'") ;
                if ( $officer->getDept() != false ){
                    $dept = $officer->getDept()->getTrack()->toArray() ;
                    // var_dump($officer->getDept()) ;
                    // exit() ;
                    foreach( $dept as $a ){
                        $cid[] = $a['cid'] ;
                    }

                    $this->view->cid = $cid ;

                    $ci = $_GET['id'] ;
                    if ( $ci ){
                        $cus = Customers::findFirst("cid = '$ci'") ;
                        $this->view->fname = $cus->fname ;
                        $this->view->sname = $cus->sname ;
                        $this->view->address = $cus->homeaddress ;
                        $this->view->phone = $cus->pnumber ;
                        $this->view->work = $cus->workaddress ;

                        $paying = $cus->getPaying()->toArray() ;
                        // $sum = $cus->getPaying()->getLoan()-toArray() ;
                        
                        foreach ( $paying as $a ){
                            $date[] = $a['date'] ;
                            $payid[] = $a['payingid'] ;
                            $cusid[] = $a['cid'] ;
                            $loanid[] = $a['loanid'] ;
                            $bal[] = $a['amount'] ;
                        }

                        $this->view->date = $date ;
                        $this->view->bal = $bal ;
                        $this->view->payid = $payid ;
                        $this->view->cusid = $cusid ;
                        $this->view->loanid = $loanid ;
                        
                    }
                }else {
                    $this->response->redirect("index") ;
                }       
            }else{
                $this->response->redirect("index") ;
            } 
                
        }

        public function calendarAction() {
            if ( $this->session->has('id') != null ) {
                $id = $this->session->get('id') ;
                $cal = Officers::findFirst("oid = '$id'") ;
                $calen = $cal->getCalendar() ;

                foreach ( $calen as $a ){
                    $cusid[] = $a->getCustomer() ;
                    $cus[] = $a->cid ;
                    $date[] = $a->date ;
                }

                // var_dump($cus);
                // exit() ;

                $this->view->cid = $cus ;

                foreach( $cusid as $a ){
                    $fname[] = $a->fname ;
                    $sname[] = $a->sname ;
                    $phone[] = $a->pnumber ;
                    $address[] = $a->homeaddress ;
                    $work[] = $a->workaddress ;
                }

                $this->view->fname = $fname ;
                $this->view->sname = $sname ;
                $this->view->phone = $phone ;
                $this->view->address = $address ;
                $this->view->work = $work ;    
                // $this->view->cid = $cusid ;
                $this->view->calendar = $date ;
            
            }else {
                $this->response->redirect('index') ;
            }
        }

        public function crmAction() {
            if ( $this->session->has('id') ){
                $id = $this->session->get('id') ;
                $off = Officers::findFirst("oid = '$id'") ;
                // var_dump($off->getCrm()) ;
                // exit() ;
                if ( $off->getCrm() != false ){
                    $offic = $off->getCrm()->getRequest() ;                
                    foreach( $offic as $a ){
                        $cusid[] = $a->getCustomers() ;
                        $ticket[] = $a->ticket_id ;
                        $request[] = $a->request ; 
                    }

                    foreach( $cusid as $a ){
                        $fname[] = $a->fname ;
                        $sname[] = $a->sname ;
                    }

                    $this->view->mess = $request ;
                    $this->view->ticket = $ticket ;
                    $this->view->fname = $fname ;
                    $this->view->sname = $sname ;

                    $idd = $_GET['id'] ;
                    if ( $idd != null ){
                    $crm = CarryRequest::findFirst("ticket_id = '$idd'") ;
                    $crm->delete() ;
                    }
                }else {
                    $this->response->redirect("officer") ;
                }
            } else {
                $this->response->redirect("index") ;
            }
        }

        public function createcalendarAction() {
            if ( $this->session->has('id') ){
                $id = $this->session->get('id') ;
                $off = Officers::findFirst("oid = '$id'") ;
                $offic = $off->getCalendar() ;

                foreach ( $offic as $a ){
                    $cus[] = $a->getCustomer() ;
                }

                foreach ( $cus as $a ){
                    $cusid[] = $a->cid ;
                }

                $this->view->cusid = $cusid ;

                $idd = $_GET['id'] ;
                if ( $idd != null ) {
                    if ( $this->request->isPost() ) {
                        // var_dump("Hello World") ;
                        // exit() ;
                        $datecal = $this->request->getPost("datecal") ;
                        $datecal1 = Calendar::findFirst("cid = '$idd'") ;
                        // var_dump($datecal1->date);
                        // exit() ;
                        $datecal1->date = $datecal ;
                        $datecal1->save() ;
                        // var_dump($datecal) ;
                        // exit() ;
                    }
                }
            }else {
                $this->response->redirect("index") ;
            }
        }

        public function userAction() {
            if ( $this->session->has('id') ){
                $id = $this->session->get('id') ;
                $us = Officers::findFirst("oid = '$id'") ;

                var_dump($us) ;
                exit() ;
            }else {
                $this->response->redirect("index") ;
            }
        }
        public function addcreditAction(){
                if ( $this->session->has('id') ) {
                    $user = Customers::find() ;

                    foreach ( $user as $a ){
                        $b[] = $a->toArray() ;
                    }
                    foreach ( $b as $c ){
                        $cusid[] = $c['cid'] ;

                    }
                    $this->view->cusid = $cusid ;
                    if ( $this->request->isPost() ){
                        $cid = $this->request->getPost("customerid") ;
                        $customer = Customers::findFirst("cid = '$cid'");
                        if($customer->getAccount() == false){
                            $gbalance = (int)($customer->balance) ;
                        
                            $this->response->redirect('officer/index') ;

                            $rand =(string)rand(10000,99999);
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "mydb";
                            $conn = new mysqli($servername, $username, $password, $dbname);
            
                            $sql = "INSERT INTO account VALUES ('$rand','$cid','A',$gbalance)";
                            $conn->query($sql);
                        }

                    }
                }else {
                    $this->response->redirect("index") ;
                }
        }

    }

?>