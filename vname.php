<?php

class vname{

	public function variableName(){

		//'val_[文字列][数字]'の規則になるように変数を宣言
		$val_hoge1 = 'hoge1';
		$val_piyo1 = 'piyo1';
		$val_piyo2 = 'piyo2';

		//上で宣言した変数の[文字列][数字]を連想配列に
		//[文字列]がkey、[数字]がvalueに対応するように
		$valList = [
			//val_hoge1
			'hoge' => [1],
			//val_piyo1,val_piyo2
			'piyo' => [1,2],
		];

		//[文字列]で回すforeach
		foreach ($valList as $key1 => $value1) {
			//[数字]で回すforeach
			foreach ($value1 as $key2 => $value2) {
				//可変変数を作成
				$vname = ${'val_' . $key1 . $value2};

				//表示(可変関数で処理を分岐させたり、可変変数の内容で分岐させたりできる・・・はず)
				echo $vname;
				echo '<br>';	
			}
		}
	}
}

//定数定義
define('INPUT_CHECK', 1);	//入力チェック
define('SELECT_CHECK', 2);	//選択チェック(ラジオボタンとか)
define('FORMAT_CHECK', 3);	//フォーマットチェック

class validator{

	public function validate(){

		// フォームとかから適当に受け取った値(仮の数値)
		$dataList = [
			'name' => 'hoge',
			'sex' => '1',	// 1:男 2:女
			'age' => '12',
		];

		// バリデーションチェックを行いたい値と内容を連想配列で指定する
		$validateFlag = [
			// 名前には入力チェックを実施
			'name' => [INPUT_CHECK],
			//性別には選択チェックを実施
			'sex' => [SELECT_CHECK],
			//年齢には入力チェックとフォーマットチェックを実施
			'age' => [INPUT_CHECK, FORMAT_CHECK],
		];

		//エラーフラグ
		$error = 1;	//true

		//正規表現
		$age_reg = "{^[0-9]{1,3}$}";	//年齢正規表現(1桁から3桁)

		//連想配列をループ
		foreach ($validateFlag as $checkTerget => $value) {
			foreach ($value as $key => $checkType) {
				//連想配列の内容によって実施する処理を分岐
				switch ($checkType) {
					case INPUT_CHECK:
						$error = self::inputCheck($dataList[$checkTerget]);	
						break;
					case SELECT_CHECK:
						$error = self::selectCheck($dataList[$checkTerget]);
						break;
					case FORMAT_CHECK:
						//可変変数で使用する正規表現を指定
						$regEx = ${$checkTerget . '_reg'};
						$error = self::formatCheck($dataList[$checkTerget], $regEx);
						break;
				}
			}
		}

		return $error;

	}

	/*
	* @return 0:false 1:true 
	*/
	private function inputCheck($value){

		self::exeEcho('input');

		if(strlen($value) == 0){
			return 0;
		}
		return 1;
	}

	/*
	* @return 0:false 1:true 
	*/
	private function selectCheck($value){

		self::exeEcho('select');

		if($value = 0){
			return 0;
		}
		return 1;
	}

	/*
	* @return 0:false 1:true 
	*/
	private function formatCheck($value, $regEx){

		self::exeEcho('format');

		return preg_match($regEx, $value);
	}

	private function exeEcho($name){
		echo $name . ' done!<br>';
	}
}

//実行
vname::variableName();

if(validator::validate()){
	echo 'エラーなし<br>';
} else {
	echo 'エラーあり<br>';
}


?>