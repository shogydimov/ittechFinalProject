<?php
/**
 * Created by PhpStorm.
 * User: Nini
 * Date: 12.10.2017 г.
 * Time: 22:30 ч.
 */

namespace model\DataBase;
use model\favorites\Favorite;

class FavouriteDao{
	private static $instance;
    /**
     * @var \PDO
     */
	private $pdo;

    /**
     * FavouriteDao constructor.
     */
	private function __construct() {
		$this->pdo = DBManager::getInstance()->getConnection();
	}

    /**
     * @return FavouriteDao
     */
	public static function getInstance(){
		if(self::$instance === null){
			self::$instance = new FavouriteDao();
		}
		return self::$instance;
	}

    /**
     * @param Favorite $favorite
     */
	public function addNewFavorite(Favorite $favorite){
		$stm = $this->pdo->prepare("INSERT INTO `favorites` (`product_id`, `user_id`) VALUES (?, ?)");
		foreach ($favorite->getProductId() as $product_id) {
			$stm-> execute(array($product_id, $favorite->getUserId()));
		}
	}

    /**
     * @param Favorite $favorite
     */
	public function deleteFavorite(Favorite $favorite){
		$stm = $this->pdo->prepare("DELETE FROM favorites WHERE (product_id = ? AND user_id = ?)");
		$stm->execute(array($favorite->getProductId(), $favorite->getUserId()));
	}
}