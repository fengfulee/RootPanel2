<?php

class rpPanelHandler extends lpHandler
{
    public function __invoke()
    {
        lpLocale::i()->load(["global", "panel", "log"]);
        global $rpROOT;

        $this->auth();

        lpTemplate::outputFile("{$rpROOT}/template/panel/index.php");
    }

    private function auth()
    {
        global $rpCfg;

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(array_key_exists(rpAuth::uname(), $rpCfg["Admins"]))
            rpApp::goUrl("/admin/", true);
    }

    public function logs($page = null)
    {
        global $rpROOT;
        lpLocale::i()->load(["global", "logs", "log"]);

        $this->auth();

        $page = intval($page);

        $tmp = new lpTemplate("{$rpROOT}/template/panel/logs.php");
        $tmp->page = $page ? : 1;
        $tmp->output();
    }
}

