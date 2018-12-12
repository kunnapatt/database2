<?php
    class UserController extends ControllerBase{
        public function indexAction(){
            if ( $this->session->has('sid') ){
                $co = $this->session->get('sid') ;
                
                $user = Customers::findFirst("cid = '$co'") ;
                // $user->getAccount() ;
                $users = $user->getAccount()->account_id ;
                $id = $user->cid ;
                $fname = $user->fname ;
                $sname = $user->sname ;
                $date = $user->DOB ;
                $gen = $user->gender ;
                $phone = $user->pnumber ;
                $addr = $user->homeaddress ;
                $work = $user->workaddress ;
                $name = $user->username ;
                $pass = $user->password ;
                $mail = $user->email ;
                $pass = $user->pass ;
                
                // var_dump($id) ;
                // exit() ;
                $this->view->balance = ($user->getAccount())->balance ;
                // var_dump($user->getAccount()->balance) ;
                // exit() ;


                $this->view->id = $id ;
                $this->view->fname = $fname ;
                $this->view->sname = $sname ;
                $this->view->gen = $gen ;
                $this->view->phone =$phone ;
                $this->view->date = $date ;
                $this->view->addr = $addr ;
                $this->view->work = $work ;
                $this->view->name = $name ;
                $this->view->mail = $mail ;
                $this->view->account = $users ;

            }else{
                var_dump("No User") ;
                exit() ;
            }
        }

        public function changeAction(){
            if ( $this->session->has('sid') ){
                if ( $this->request->isPost() ){
                    // exit() ;
                    $co = $this->session->get('sid') ;
                    $user = Customers::findFirst("cid = '$co'") ;
                    $pass = $user->password ;
                    $current = $this->request->getPost("currentpass") ;
                    $new = $this->request->getPost("newpass") ;
                    $confirm = $this->request->getPost("conpass") ;

                    if ( $pass == $current ){

                        if ( $new == $confirm ) {

                            $user->password = $new ;
                            $user->save() ;
                            var_dump("OK Success") ;
                            $this->response->redirect("user") ;
                        }else{
                            var_dump("Error new not equal comfirm") ;
                            exit() ;
                        }
                    }else{
                        $this->response->redirect("user/change") ;
                    }
                }
            }else{
                var_dump("Not User") ;
                exit() ;
            }
        }

        public function statementAction() {
            if ( $this->session->has('sid') ){
                $co = $this->session->get('sid') ;
                $user = Customers::find("cid = '$co'") ;

                
                // Array Multi values 
                // foreach ( $user as $loan){
                //     $i = ($loan)->getLoan()-> toArray() ;
                
                // }
                // foreach( $i as $j ){
                //     $k[] = $j['loanid'] ;
                //     // var_dump($j['loanid']) ;
                // }
                // var_dump($k[0]) ;
                // exit() ;

                foreach( $user as $pay ){
                    $i = $pay->getPaying()->toArray() ;
                    
                }
                $count = 0;
                foreach( $i as $j ){
                    
                    $k[] = $j['payingid'] ;
                    $date[] = $j['date'] ;
                    $payingid[] = $j['payingid'] ;
                    $amount[] = $j['amount'] ;
                    $count++ ;
                }
                $this->view->date = $date ;
                $this->view->payingid =$payingid ;
                $this->view->amount = $amount ;
            }else{
                var_dump("Not user") ;
                exit() ;
            }

        }

        public function CalendarAction() {
            if ( $this->session->has('sid') ){
                $co = $this->session->get('sid') ;
                $user = Customers::find("cid = '$co'") ;
                $d = Calendar::find("oid = '232323'") ;

                foreach( $d as $dd ){
                    $raiwa[] = $dd->date ;
                } 

                foreach ( $user as $a ){
                    $b = ($a->getCalendar()->toArray()) ;
                    var_dump($b) ;
                }
                
            }else {
                var_dump("Don't User") ;
                exit() ;
            }
        }
        public function loanAction() {
            if ( $this->session->has('sid') ){
                
                $co = $this->session->get('sid') ;
                $user = Customers::findFirst("cid = '$co'") ;
                         
                var_dump($user->getLoanBy()->toArray()) ;
                if( $user->getLoanBy()->toArray() != null ){
                
                $i = $user->getLoanBy()->toArray() ;
                $k = $user->getLoan()->toArray() ;
                $count = 0;
                foreach( $i as $j ){             
                    $loanid[] = $j['loanid'] ;
                    $asset_info[] = $j['asset_information'] ;
                    $asset_type[] = $j['asset_type'] ;

                    $count++ ;
                }
                $countt = 0;
                foreach( $k as $j ){             
                    $loanamount[] = $j['loanamount'] ;
                    $insterestrate[] = $j['insterestrate'] ;
                    $pay_per_month[] = $j['pay_per_month'] ;
                    $countt++ ;
                }
                                   
                $this->view->loanid = $loanid ;
                $this->view->asset_info =$asset_info ;
                $this->view->asset_type =$asset_type ;
                $this->view->loanamount = $loanamount ;
                $this->view->insterestrate =$insterestrate ;
                $this->view->pay_per_month =$pay_per_month ;
            }else{
                $this->response->redirect("index") ;
            }
            }else{
                var_dump("Not user") ;
                exit() ;
            }

        }

        public function CreditAction() {
            if ( $this->session->has('sid') ){
                $co = $this->session->get('sid') ;
                $user = Account::find("cid = '$co'") ;        

                foreach( $user as $ln ){
                    $i = $ln->getCredit()->toArray() ;                 
                }
                
                $countt = 0;
                foreach( $i as $j ){      
                    $Creditcardnumber[] = $j['Creditcardnumber'] ;
                    $expire_date[] = $j['expire_date'] ;
                    $limit[] = $j['limit'] ;
                    $countt++ ;
                }

                $this->view->Creditcardnumber = $Creditcardnumber ;
                $this->view->expire_date = $expire_date ;
                $this->view->limit = $limit ;
                
            }else{
                var_dump("Not user") ;
                exit() ;
            }

        }
        public function addloanAction(){
            if ( $this->session->has('sid') ){
                $co = $this->session->get('sid') ;
                $user = Customers::find("cid = '$co'") ;

                if ( $this->request->isPost() ){
                    $amount = $this->request->getPost("amount") ;
                    $asset = $this->request->getPost("asset") ;
                    $assetprice = $this->request->getPost("price") ;
                    $this->response->redirect('user/added') ;
                    
                    $rand =rand(10000,99999);
                    $strrand = (string)$rand;
                    $strasset = (string)$asset;
                    $intp = (int)$assetprice;
                    $json = '{'."\n".'"type" : "'.$strasset.'"'."\n".',"price" : "'.$intp.'"'."\n".'}';
                    
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "mydb";
                    $conn = new mysqli($servername, $username, $password, $dbname);
    
                    $sql = "INSERT INTO loan_information VALUES ($strrand,$amount,0.01,100)";
                    $conn->query($sql);

                    $sql = "INSERT INTO loan_by (cid,loanid,asset_information) VALUES ($co,$strrand,'$json')";
                    $conn->query($sql);
                }
                
            }else {
                var_dump("Don't User") ;
                exit() ;
            }
        }
        public function addedAction(){
            if ( $this->request->isPost() ){
                $this->response->redirect('user') ;
            }
        }
        public function payloanAction(){
            if ( $this->session->has('sid') != null ){
                $id = $this->session->get('sid') ;
                $cus = Customers::findFirst("cid = '$id'") ;
                if ( $cus->getLoan() != false ){
                    $loan = $cus->getLoan()->toArray() ;
                    // var_dump($officer->getDept()) ;
                    // exit() ;
                    foreach( $loan as $a_loan ){
                        $manyloan[] = $a_loan['loanid'] ;
                    }

                    $this->view->manyloan = $manyloan ;
                }
                if ( $this->request->isPost() ){
                    $amount = $this->request->getPost("amount") ;
                    $date = $this->request->getPost("date") ;
                    $loan = $this->request->getPost("loan") ;
                    $this->response->redirect('user/added') ;
                    // var_dump($id);
                    // var_dump($loan);
                    // var_dump($date);
                    // var_dump($amount);
                    //  exit();
                    $rand =rand(10000000,99999999);
                    $set = (int)$amount;
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "mydb";
                    $conn = new mysqli($servername, $username, $password, $dbname);
    
                    $sql = "INSERT INTO paying VALUES ($rand,'$id','$loan','$date',$set)";
                    $conn->query($sql);

                }
            }
        }

        public function historyAction() {
            if ( $this->session->has('sid') != null ){
                $id = $this->session->get('sid') ;
                $user = Customers::findFirst("cid = '$id'") ;
                if ( $user->getLoan() != false ){
                    $loans = $user->getLoan()->toArray() ;
                    // var_dump($officer->getDept()) ;
                    // exit() ;
                    foreach( $loans as $a_loan ){
                        $manyloan[] = $a_loan['loanid'] ;
                    }

                    $this->view->manyloan = $manyloan ;

                    $ci = $_GET['id'] ;
                    if ( $ci ){
                        $loan = LoanInformation::findFirst("loanid = '$ci'") ;
                        $this->view->loanamount = $loan->loanamount ;
                        $this->view->insterestrate =$loan->insterestrate ;
                        $this->view->pay_per_month =$loan->pay_per_month ;
                        $this->view->loanidd = $loan->loanid ;

                        if ( $loan->getPaying() != false ){
                            $paying = $loan->getPaying()->toArray() ;
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
                    }
                }else {
                    $this->response->redirect("index") ;
                }       
            }else{
                var_dump("Don't User") ;
                exit() ;
            } 
                
        }

        public function RequestAction(){
            if ( $this->session->has('sid') ){
                $co = $this->session->get('sid') ;
                $user = Customers::findFirst("cid = '$co'") ;

                if ( $this->request->isPost() ){
                    $request = $this->request->getPost("request") ;
                    $crm = CrmOfficer::findFirst()->oid;
                    $this->response->redirect('user/added') ;
                    
                    $rand =rand(10000000,99999999);
                    $strrand = (string)$rand;
                    $strasset = (string)$asset;
                    $intp = (int)$assetprice;
                    
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "mydb";
                    $conn = new mysqli($servername, $username, $password, $dbname);
    
                    $sql = "INSERT INTO carry_request VALUES ('$co','$crm','$strrand','$request')";
                    $conn->query($sql);
                }
                
            }else {
                var_dump("Don't User") ;
                exit() ;
            }
        }
        public function AddCreditAction(){
            if ( $this->session->has('sid') ){
                $co = $this->session->get('sid') ;
                $user = Customers::findFirst("cid = '$co'") ;

                if($user->getAccount() != false){
                    if ( $this->request->isPost() ){
                        $request = (int)$this->request->getPost("limit") ;
                        $this->response->redirect('user/added') ;
                        
                        $rand =rand(1000,9999);
                        $date= "2020-8-11";
                        
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "mydb";
                        $conn = new mysqli($servername, $username, $password, $dbname);
        
                        $sql = "INSERT INTO credit VALUES ('$rand','$co','$date',$request)";
                        $conn->query($sql);
                    }
                }
                
            }else {
                var_dump("Don't User") ;
                exit() ;
            }
        }

        public function MoneyTranAction() {
            if  ( $this->session->get('sid') ) {
                $cus = $this->session->get('sid') ;
                $user = Customers::findFirst("cid = '$cus'") ;
                $bal = $user->balance ;                

                $this->view->fname = $user->fname ;
                $this->view->sname = $user->sname ;
                $this->view->bal = $bal ;

                if ( $this->request->isPost() ){
                    $numacc = $this->request->getPost("numaccount") ;
                    $money = $this->request->getPost("money") ;
                    $user2 = Customers::findFirst("cid = '$numacc'") ;                  

                    if ( $user2 ) {
                        if ( $bal - $money < 0 ) {
                            var_dump("เงินไม่พอ") ;
                            exit() ;
                        }else if ( $bal - $money >= 0 ){
                            $trans = $bal - $money ;
                            $user->balance = $trans ;
                            
                            
                            $trans2 = $user2->balance + $money ;
                            $user2->balance = $trans2 ;
                            

                            $user->save() ;
                            $user2->save() ;
                            $this->response->redirect("index") ;
                            // var_dump($trans2) ;
                            // exit() ;
                        }
                    }else {
                        var_dump("Don't have account") ;
                        exit() ;
                    }
                }

                var_dump($bal) ;
                // exit() ;
            }else {
                var_dump("Don't User") ;
                exit() ;
            }
        }
        
    }
?>