<?php
// veritabanı bağlantısı için gerekli olan bilgiler girilir.

// host: veritabanının bulunduğu sunucu, biz yerelde olduğumuz için localhost.
$host = "localhost";
// dbName: veritabanının adı.
$dbName = "getirme";
// root: veritabanı kullanıcı adı.
$root = "root";
// psw: veritabanı şifresi.
$psw = "";

// try catch yapısı ile veritabanı bağlantısı esnasında oluşabilecek hatalar yakalanır.
try {
	/* 	PDO sınıfı ile veritabanı bağlantısı yapılır. Bağlantı başarılı olursa devam eder,
		die ile bağlantı başarısız olursa hata mesajı verilir. */
	$dbconn = new PDO("mysql:host=$host;dbname=$dbName", $root, $psw) or
		die("baglanti olmadi.");
} catch (PDOException $e) {
	/* catch bloğu hata esnasında gelen hata
		parametresini yakalar ve ekrana basar. */
	echo "hata: " . $e;
}

?>