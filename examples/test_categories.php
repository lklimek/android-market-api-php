<?php
include("local.php");
include("../proto/protocolbuffers.inc.php");
include("../proto/market.proto.php");
include("../Market/MarketSession.php");

$session = new MarketSession();
$result = $session->login(GOOGLE_EMAIL, GOOGLE_PASSWD);
if ($result == false) {
    echo "ERROR: cannot login as " . GOOGLE_EMAIL;
    exit(1);
}
$session->setAndroidId(ANDROID_DEVICEID);

$cr = new CategoriesRequest();

$reqGroup = new Request_RequestGroup();
$reqGroup->setCategoriesRequest($cr);
$response = $session->execute($reqGroup);

$groups = $response->getResponsegroupArray();
foreach ($groups as $rg) {
	$categoriesResponse = $rg->getCategoriesResponse();
	$categories = $categoriesResponse->getCategoriesArray();
	foreach ($categories as $category) {
		echo $category->getTitle()."<br/>";

		$subcategories = $category->getSubCategoriesArray();
		foreach ($subcategories as $subcategory) {
			echo "- ".$subcategory->getTitle()."<br/>";
		}
	}
}