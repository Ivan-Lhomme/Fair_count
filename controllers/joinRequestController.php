<?php
class joinRequestController extends AbstractController{
    public function accept() {
        $jrm = new joinRequestManager;
        $gum = new GroupUserManager;

        $jrm->updateStatus($_GET["joinRequestId"], "accepted");

        $groupId = $jrm->findById($_GET["joinRequestId"])->getGroupId();
        $gum->create($groupId, $_SESSION["id"]);

        $this->redirect("?route=profile");
    }

    public function refuse() {
        $jrm = new joinRequestManager;
        $jrm->updateStatus($_GET["joinRequestId"], "refused");

        $this->redirect("?route=profile");
    }
}