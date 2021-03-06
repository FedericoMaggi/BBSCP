<?
	/********************************************/
	/******* BestBug Studio Control Panel *******/
	/********************************************/

include_once dirname(__FILE__).'/modelinterface.php';
include_once dirname(__FILE__).'/responseFunction.php';

Class User implements modelinterface{

	private $id, $nickname, $password, $firstname, $lastname, $mail, $confirmed;

	public function __construct($id, $nickname, $password, $firstname, $lastname, $mail, $confirmed){
		$this->id = $id;
		$this->nickname = $nickname;
		$this->password = $password;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->mail = $mail;
		$this->confirmed = $confirmed;
	}

	public static function userLogger($nickname, $password){
		return new self(null,$nickname,$password,null,null,null,null);
	}

	public function getObjectData(){
		return json_encode(array(
				'id'		=> $this->id,
				'nickname'	=> $this->nickname,
				'password'	=> $this->password,
				'firstname'	=> $this->firstname,
				'lastname'	=> $this->lastname,
				'mail'		=> $this->mail,
				'confirmed' => $this->confirmed
			));
	}

	public function getId(){
		return $this->id;
	}

	public function getFromId($id){
		$DB = new Database(Install::getInstance());
		$Q = new Query();
		$DB->connect();

		$res = $DB->startQuery($Q->getUserFromId($id));
		$res = $DB->returnFirstRow($res);

		$DB->disconnect();
		sendResponse('Here\'s the user you asked for','No user found',$res,false);
	}

	public static function getAllData(){
		$DB = new Database(Install::getInstance());
		$Q = new Query;
		$DB-> connect();

		$res = $DB->startQuery($Q->getAllUsers());
		$res = $DB->returnAllRows($res);

		$DB->disconnect();
		sendResponse('Users found','No users found',$res,false);
	}

	public function addNewData(){
		$DB = new Database(Install::getInstance());
		$Q = new Query();
		$DB->connect();

		$res = $DB->startQuery($Q->addNewUser($this->getObjectData()));

		$DB->disconnect();
		sendResponse('User successfully added','Something went wrong with the query',null,true);
	}

	public function updateData(){
		$DB = new Database(Install::getInstance());
		$Q = new Query();
		$DB->connect();

		$res = $DB->startQuery($Q->updateUser($this->getObjectData()));

		$DB->disconnect();
		sendResponse('User info successfully update','Something went wrong, check the information you provided',null,true);
	}

	public function deleteData(){
		$DB = new Database(Install::getInstance());
		$Q = new Query();
		$DB->connect();

		$res = $DB->startQuery($Q->deleteUser($this->getId()));

		$DB->disconnect();
		sendResponse('User deleted successfully','Something went wrong while deleting the user',null,true);
	}
}
	/********************************************/
	/******* BestBug Studio Control Panel *******/
	/********************************************/
?>