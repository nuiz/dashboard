<?php
namespace DashboardSocial;

class DashboardService {
	private $pdo;
	public function getPDO(){
		return $this->pdo;
	}
	public function setPDO(\PDO $pdo){
		return $this->pdo = $pdo;
	}
	public function addPage($pageId, $pageToken, $userId, $pageName){
		$stmt = $this->pdo->prepare("INSERT INTO `facebook_page`(`facebook_page_id`, `access_token`, `facebook_user_id`, `facebook_page_name`) VALUES(?, ?, ?, ?)");
		$stmt->execute([$pageId, $pageToken, $userId, $pageName]);
	}

	public function getPages($fbUserId){
		$stmt = $this->pdo->prepare("SELECT * FROM `facebook_page` WHERE `facebook_user_id`=:facebook_user_id");
		$stmt->execute(['facebook_user_id'=> $fbUserId]);
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}