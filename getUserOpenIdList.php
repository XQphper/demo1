<?php

include "./wxModel.php";

$wxObj = new wxModel();

echo $wxObj->getUserOpenIdList();