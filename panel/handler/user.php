<?php

class JBSignup extends lpPage
{
    private $msg;
    
    public function get()
    {
        return lpTemplate::parseFile("template/signup.php");
    }

    public function post()
    {
        global $lpCfgTimeToChina;
        
        if(!isset($_POST["uname"]) or !isset($_POST["email"]))
        {
            $this->msg="请将信息填写完整";
            return false;
        }
        
        if(!preg_match('/[\x{4e00}-\x{9fa5}A-Za-z0-9_]+/u',$_POST["uname"]) or
           !preg_match('/[A-Za-z0-9_\-\.\+]+@[A-Za-z0-9_\-\.]+/',$_POST["email"]))
        {
            lpBeginBlock();?>
              <ul>
                <li>帐号仅可以使用中文、英文、数字和下划线</li>
                <li>邮箱务必为正确的邮箱地址</li>
              </ul>
            <?php
            $this->msg=lpEndBlock();
            return false;
        }

        $conn=new lpMySQL;

        $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
        if($rs->read())
        {
            $this->msg="帐号已存在";
            return false;
        }

        $row["uname"]=$_POST["uname"];
        $row["passwd"]=lpAuth::DBHash($_POST["uname"],$_POST["passwd"]);
        $row["email"]=$_POST["email"];
        $row["regtime"]=time()+$lpCfgTimeToChina;

        $conn->insert("user",$row);
        
        lpAuth::login($row["uname"],$row["passwd"],false,true);
        
        $this->gotoUrl("/profile/");
        return true;
    }
    
    public function procError()
    {
        $this->httpCode=400;
        
        $tmp=new lpTemplate;
        
        $a["errorMsg"]=$this->msg;
        $a["uname"]=$_POST["uname"];
        $a["email"]=$_POST["email"];
            
        $tmp->parse("template/signup.php",$a);
    }
}

class JBLogin extends lpPage
{
        private $msg;
        
    public function get()
    {
            return lpTemplate::parseFile("template/login.php");
    }
    
    public function post()
    {
        if(!isset($_POST["uname"]) or !isset($_POST["passwd"]))
        {
            $this->msg="请输入账号和密码";
            return false;
        }
        
        if(lpAuth::login($_POST["uname"],$_POST["passwd"]))
        {
            $this->gotoUrl(isset($_GET["next"])?$_GET["next"]:"/");
                return true;
        }
        else
        {
            $this->msg="用户名或密码错误";
            return false;
        }
    }
    
    public function procError()
    {
            $this->httpCode=400;
            
            $tmp=new lpTemplate;
            
            $a["errorMsg"]=$this->msg;
            $a["uname"]=$_POST["uname"];
            
          $tmp->parse("template/login.php",$a);
    }
}

class JBLogout extends lpPage
{
    public function get()
    {
        lpAuth::logout();
        $this->gotoUrl("/");
        
        return true;
    }
}

?>
