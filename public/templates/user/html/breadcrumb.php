<?php
$linkLogin        = $this->url('MVC_HomeRouter/action',array('module'=>'home','controller'=>'user','action'=>'login'));
$linkLogout       = $this->url('MVC_HomeRouter/action',array('module'=>'home','controller'=>'user','action'=>'logout'));

$linkRegister     = $this->url('MVC_HomeRouter/action',array('module'=>'home','controller'=>'user','action'=>'register'));
$linkInfoAccount  = $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'account','action'=>'index'));
$actionUser = '';
if(empty($this->identity()->id)){
    $actionUser = '<div class="one"><a href="'.$linkLogin.'" class="signIn"  title="Đăng nhập tài khoản">Đăng nhập</a>
            <a href="'.$linkRegister.'"   class="createNew" title="Tạo tài khoản ">Tạo tài khoản</a></div>';
}else{
    $actionUser = '<div class="two"><span>Chào bạn: '.$this->identity()->fullname.'</span>
                    <a href="'.$linkInfoAccount.'" class="account" title="Tài khoản" rel="nofollow">Tài khoản</a>
                    <a href="'.$linkLogout.'"  class="signOut"  title="Đăng xuất tài khoản" rel="nofollow">Đăng xuất</a></div>';
}

?>
  
    

<div class="breadCrumb">
    <div itemtype="http://data-vocabulary.org/Breadcrumb" itemscope>
      <a itemprop="url" href="#"><span itemprop="title">Trang chủ</span></a>
    </div> 
     
   </div>
<div class="accountGroup" id="phLogin">
    <?php echo $actionUser;?>
</div>

<script type="text/javascript">
function logoutAccount(){

}
</script>
   

  
    