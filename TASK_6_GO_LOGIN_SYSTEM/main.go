package main


import (
	"encoding/json"
	"fmt"
	"os"
	"log"
	
	
	
	
)
var logFile *os.File // Ayrı fonksiyonlarda aynı kayıt defterine yazmam için gerekliymiş, Global değişken atadım
type User struct { // User isminde username ve paroladn oluşan bir struct yazdım.
    Username string `json:"username"` 
    Password string `json:"password"` 
	Admin    bool   `json:"admin"`
}

type Referans struct {
    Refferance string
}

var referans = Referans{Refferance: "WUBXfF98WkxhUjJPMjQ"} //referans kodum

func adminRegSystem() {

	var newUserName, newPassword, againNewPassword , adminsAnswer string
	var adminChacked bool = true

	fmt.Print("\n \n ****************************************[ KAYDET ]************************************************** \n")

	fmt.Print("Kullanıcı adını girin: ")
    fmt.Scan(&newUserName)

	fmt.Print("Şifreyi girin: ")
    fmt.Scan(&newPassword)

	fmt.Print("Şifreyi tekrar girin: ")
    fmt.Scan(&againNewPassword) 

	fmt.Print("Kullanıcıyı Admin olarak mı ekleyeceksiniz (y / n)")
	fmt.Scan(&adminsAnswer) 

	for adminsAnswer != "y" && adminsAnswer != "n" {
        fmt.Print("Lütfen geçerli cevap verin (y / n): ")
        fmt.Scan(&adminsAnswer)
    } 

	if adminsAnswer == "y" {
		adminChacked = true
	} else if adminsAnswer == "n" {
		adminChacked = false
	}

	if againNewPassword != newPassword {
		fmt.Print("Hatalı Doğrulama: ilk şifreniz ile ikinci şifreniz aynı değil!\n")
		log.SetOutput(logFile)
		 message := " Doğrulanamayan Şifre tekrarı : "    // direk logPrintln ile yazdırınca hata veriyor anlamadım. 
		 log.Println(message , newUserName)
		 os.Exit(1)
	} else {
			saveJSON(newUserName , newPassword ,adminChacked)

	}


}


func register() {
	var newUserName, newPassword, againNewPassword , adminSave , refferance string
	var isAdmin bool = false
	

	fmt.Print("\n \n ***************************************[ KAYIT OL ]************************************************* \n")

	
	fmt.Print("Kullanıcı adını girin: ")
    fmt.Scan(&newUserName)

    fmt.Print("Şifreyi girin: ")
    fmt.Scan(&newPassword)

	fmt.Print("Şifreyi tekrar girin: ")
    fmt.Scan(&againNewPassword)

	fmt.Print("Admin olarak mı kayıt olacaksınız? (y / n)") 
    fmt.Scan(&adminSave) 

	for adminSave != "y" && adminSave != "n" {
        fmt.Print("Lütfen geçerli cevap verin (y / n): ")
        fmt.Scan(&adminSave)
    } 

	if adminSave == "y" {
		fmt.Print("Lutfen Admin Tarafından Verilmiş Olan Referans Kodunu giriniz: ")
		fmt.Scan(&refferance)
		if refferance != referans.Refferance {
			fmt.Print("Referans Kodu Karşılanamıyor")
			os.Exit(1)
		}else {
			isAdmin = true
		}

	}


	if againNewPassword != newPassword {
		fmt.Print("Hatalı Doğrulama: ilk şifreniz ile ikinci şifreniz aynı değil!\n")
		log.SetOutput(logFile)
		 message := " Doğrulanamayan Şifre tekrarı : "    // direk logPrintln ile yazdırınca hata veriyor anlamadım. 
		 log.Println(message , newUserName)
		os.Exit(1)
	} else {
			saveJSON(newUserName , newPassword ,isAdmin)

	}

}

func checkError (err error) {
	if err != nil {
		fmt.Println("Fatal Error: ", err.Error())
		os.Exit(1)
	}
}

func saveJSON(user string, passwd string , isAdmin bool) {
    var sonKarar string
	var users []User


    fmt.Printf("User Name: %s \n Parola: %s\n", user, passwd)
    fmt.Print("Sisteme kaydolunacaksınız, emin misiniz? (y / n): ")
    fmt.Scan(&sonKarar)

    for sonKarar != "y" && sonKarar != "n" {
        fmt.Print("Lütfen geçerli cevap verin (y / n): ")
        fmt.Scan(&sonKarar)
    }
	

    if sonKarar == "y" {
		if isAdmin == true {
			fmt.Print("WARNİNG: Kullanıcı sisteme Admin olarak kaydedilecek son kararınız mı (y / n)")
			fmt.Scan(&sonKarar)

			for sonKarar != "y" && sonKarar != "n" {
				fmt.Print("Lütfen geçerli cevap verin (y / n): ")
				fmt.Scan(&sonKarar)
			}

		}





		// Kodu bilmiyorum kopyalama yaptım.
		if _, err := os.Stat("Users.json"); err == nil {
            fileData, err := os.ReadFile("Users.json")
            checkError(err)
            json.Unmarshal(fileData, &users)
        }

		for _, u := range users {
            if u.Username == user {
                fmt.Println("System Message: Bu kullanıcı adı zaten mevcut!")
				log.SetOutput(logFile)
		 		message := " Aynı kullanıcı isminde kayıt : KAYIT BAŞARISIZ , "    
				log.Println(message , user)
                register()
				return
            }
        }
       
        
        inFile, err := os.Open("Users.json")
        if err == nil {
            decoder := json.NewDecoder(inFile)
            err = decoder.Decode(&users)
            inFile.Close()
			log.SetOutput(logFile)
		 	message := " Sisteme bir kullanıcı eklendi : "    
			log.Println(message , user)

        }

        newUser := User{Username: user, Password: passwd , Admin: isAdmin}
        users = append(users, newUser)

      
        outFile, err := os.Create("Users.json")
        checkError(err)
        encoder := json.NewEncoder(outFile)
        err = encoder.Encode(users)
        checkError(err)
        outFile.Close()

        fmt.Println("System Message: Kayıt başarılı!")
    } else if sonKarar == "n" {
        fmt.Println("Programdan Çıkılıyor...")
        os.Exit(1)
    }
}




func Dogrulama(username string , password string , isAdmin bool) bool {

	var users []User
	

	if _, err := os.Stat("Users.json"); err == nil {
		fileData, err := os.ReadFile("Users.json")
		checkError(err)
		json.Unmarshal(fileData, &users)
	}

	for _, u := range users {
		if u.Username == username  && u.Password==password && u.Admin==isAdmin {
			fmt.Println("System Message: Login Successful!")
			log.SetOutput(logFile)
		 	message := " Sisteme giriş yapıldı : "    
			log.Println(message , username)

			return true
		} 

		
		
	}

  

    return false
}

// Login Function
func login() {
    var username , password , adminSorgu string
	var isAdmin bool
	

	fmt.Print(" \n \n *******************************************[ LOGİN PANEL ]******************************************* \n")


    fmt.Print("Kullanıcı adını girin: ")
    fmt.Scan(&username)
    fmt.Print("Şifreyi girin: ")
    fmt.Scan(&password)
	fmt.Print("Admin Olarak mı giriş yapıyorsunuz? (y / n) ")
    fmt.Scan(&adminSorgu)

	for adminSorgu != "y" && adminSorgu != "n" {
		fmt.Print("Lütfen geçerli cevap verin (y / n): ")
		fmt.Scan(&adminSorgu)
	}

	if adminSorgu == "y" {
		isAdmin = true
	}else {
		isAdmin = false
	}



  
    if Dogrulama(username, password , isAdmin) {
        fmt.Println("\nAna programa yönlendiriliyorsunuz...\n ")

		if isAdmin== true{
			AdminPanel(username , password)
		}else{   
			UserPanel(username , password)
		}
       
    } else {
        fmt.Println("Giriş başarısız! Kullanıcı adı veya şifre hatalı.")
		log.SetOutput(logFile)
		message := " Hatalı Giriş, Şifre ya da parola hatalı : "    
		log.Println(message , username)
    }
}



func AdminPanel(userName string , passwd string) {
	var adminSecimi , exit int
	var changePassword , ChangePasswordAgain , deleteName , karar string
	var users []User
	
	
	
	log.SetOutput(logFile)
	message := ", Admin olarak siteme giriş yaptı : "    
	log.Println(userName , message)

	fmt.Print(" \n \n ****************************************[ HELLO ADMİN PANEL ]**************************************** \n")

	fmt.Print("\n Kullanıcı: " , userName)
	fmt.Print("\n*************************\n*                       *\n* 1-) Profile info      *\n* 2-) Change Passwd     *\n* 3-) Add User          *\n* 4-) Delete User       *\n* 5-) LOG İncele        *\n* 0-) Quit              *\n*                       *\n*************************")
	fmt.Print("\n \n SEÇİM: ")
	fmt.Scan(&adminSecimi)

	for adminSecimi != 1 && adminSecimi != 2 && adminSecimi != 0 && adminSecimi!=3 && adminSecimi!= 4 && adminSecimi!= 5{
		fmt.Print("Lütfen menüde olan numaraları girin: ")
		fmt.Scan(&adminSecimi)
	}

	if adminSecimi == 1 {
		fmt.Println("User Name: " , userName)
		fmt.Println("Password: " , passwd)
		fmt.Print("\n \n Çıkış için (0) " )
		fmt.Scan(&exit)
		for exit != 0{
			fmt.Print("Lütfen çıkmak için 0 tuşlayın:  ")
			fmt.Scan(&exit)
		}
		if exit == 0 {
			AdminPanel(userName , passwd)
			return
		}
	}else if adminSecimi == 2 {

		

		fmt.Print("Yeni Şifreyi Belirleyin: ")
		fmt.Scan(&changePassword)
		fmt.Print("Şifrenizi Tekrarlayın: ")
		fmt.Scan(&ChangePasswordAgain)

		if ChangePasswordAgain != changePassword {
			fmt.Print("Şifreler uyuşmuyor... Şifre değiştirilemedi.")
			log.SetOutput(logFile)
			message := " Şifre değiştirme : BAŞARISIZ , "    
			log.Println(message , userName)
			AdminPanel(userName , passwd)
			return

		} else if changePassword == ChangePasswordAgain {

			if _, err := os.Stat("Users.json"); err == nil {
				fileData, err := os.ReadFile("Users.json")
				checkError(err)
				json.Unmarshal(fileData, &users)
			}

			for i, u := range users {
				if u.Username == userName {
					users[i].Password = changePassword 
					fmt.Println("Şifre başarıyla değiştirildi.")
					log.SetOutput(logFile)
					message := " Şifre Değiştirme : BAŞARILI , "    
					log.Println(message, userName)
				}
			}
			
			
			outFile, err := os.OpenFile("Users.json", os.O_WRONLY|os.O_TRUNC|os.O_CREATE, 0644)
   			checkError(err)
    		defer outFile.Close()

    		encoder := json.NewEncoder(outFile)
    		err = encoder.Encode(users) 
    		checkError(err)
			AdminPanel(userName , passwd)


		}



	}else if adminSecimi == 3 {

		fmt.Print("Kayıt formuna gönderileceksiniz. İşlemi onaylıyor musunuz? (y / n)")
		fmt.Scan(&karar) 

		for karar != "y" && karar != "n" {
			fmt.Print("Lütfen geçerli cevap verin (y / n): ")
			fmt.Scan(&karar)
		}

		if karar == "y" {
			adminRegSystem()
			fmt.Print("Kullanıcı Sisteme Eklandi")
			log.SetOutput(logFile)
			message := ", Sisteme Bir kullanıcı ekledi. "    
			log.Println(userName, message)
			AdminPanel(userName , passwd)
		}else {
			AdminPanel(userName , passwd)
		}





	}else if adminSecimi == 4 {
		fmt.Print("Silinecek olan kullanıcının User Name'ini yazın: ")
		fmt.Scan(&deleteName)

		if _, err := os.Stat("Users.json"); err == nil {
			fileData, err := os.ReadFile("Users.json")
			checkError(err)
			json.Unmarshal(fileData, &users)
		}

		for i, u := range users {
			if u.Username == deleteName {

				if userName == "admin" || userName == "MRX"{
			
				users = append(users[:i], users[i+1:]...) 
				fmt.Println(deleteName, "kullanıcısı silindi.")
		
				log.SetOutput(logFile)
				message := " Kullanıcısı Admin Tarafından Silindi "
				log.Println(deleteName, message)
	
				outFile, err := os.Create("Users.json") // Create sayesinde dosyayı yeniden yazma işlemi oluyor. ama büyük kullanıcı girişlerinde etkili mi bilmiyorum. yavaşlama ihtimali söz konuusu olabilir
				if err != nil {
					checkError(err)
				}
				encoder := json.NewEncoder(outFile)
				err = encoder.Encode(users) 
				if err != nil {
					checkError(err)
				}
				outFile.Close()
				AdminPanel(userName , passwd)

				}else if u.Admin == true {
					fmt.Print("\n  \n SYSTEM MESSAGE:  Admin kullanıcıları yalnızca MRX ve admin kullanıcısı silebilir. Adminsiniz fakat adminleri silmeye yetkiniz yok. \n \n " )
					log.SetOutput(logFile)
					message := ", Admin bir Kullanıcı silme girişiminde bulundu "
					log.Println(userName, message)
					fmt.Print("\n Sistemden Atıldınız...")
					os.Exit(1)
				}else if u.Admin == false {

					users = append(users[:i], users[i+1:]...) 
				fmt.Println(deleteName, "kullanıcısı silindi.")
		
				log.SetOutput(logFile)
				message := " Tarafından Silindi "
				log.Println(deleteName, "Kullanıcısı" , userName ,message)
	
				outFile, err := os.Create("Users.json") // Create sayesinde dosyayı yeniden yazma işlemi oluyor. ama büyük kullanıcı girişlerinde etkili mi bilmiyorum. yavaşlama ihtimali söz konuusu olabilir
				if err != nil {
					checkError(err)
				}
				encoder := json.NewEncoder(outFile)
				err = encoder.Encode(users) 
				if err != nil {
					checkError(err)
				}
				outFile.Close()
				AdminPanel(userName , passwd)

				}
			}
		}
		



			
	}else if adminSecimi == 5 {
		content, err := os.ReadFile("Log.txt")
    if err != nil {
        checkError(err)
    }

    
    fmt.Println(string(content))

	fmt.Print("\n \n Çıkış için (0) " )
		fmt.Scan(&exit)
		for exit != 0{
			fmt.Print("Lütfen çıkmak için 0 tuşlayın:  ")
			fmt.Scan(&exit)
		}
		if exit == 0 {
			AdminPanel(userName , passwd)
			return
		}


	}else if adminSecimi == 0 {
		fmt.Print("Çıkış yapılıyor...")
		log.SetOutput(logFile)
		message := " Kullanıcısı Çıkış Yaptı. "    
		log.Println(userName , message)
		os.Exit(1)
	}


	
}



func UserPanel(userName string , passwd string) {
	var users []User
	var secim2 int
	var exit int
	var changePassword , ChangePasswordAgain string


	fmt.Print(" \n \n ****************************************[ HELLO USER PANEL ]***************************************** \n")
	
	fmt.Println("\n \n \n Kullanıcı: " , userName )
	fmt.Print("*********************\n*                   *\n* 1-) Profile info  *\n* 2-) Change Passwd *\n* 0-) Quit          *\n*                   *\n*********************")

	fmt.Print("\n \n SEÇİM: ")
	fmt.Scan(&secim2)

	for secim2 != 1 && secim2 != 2 && secim2 != 0 {
		fmt.Print("Lütfen menüde olan numaraları girin: ")
		fmt.Scan(&secim2)
	}

	if secim2 == 1 {
		fmt.Println("User Name: " , userName)
		fmt.Println("Password: " , passwd)
		fmt.Print("\n \n Çıkış için (0) " )
		fmt.Scan(&exit)
		for exit != 0{
			fmt.Print("Lütfen çıkmak için 0 tuşlayın:  ")
			fmt.Scan(&exit)
		}
		if exit == 0 {
			UserPanel(userName , passwd)
			return
		}


	}else if secim2 == 2 {

		fmt.Print("Yeni Şifreyi Belirleyin: ")
		fmt.Scan(&changePassword)
		fmt.Print("Şifrenizi Tekrarlayın: ")
		fmt.Scan(&ChangePasswordAgain)

		if ChangePasswordAgain != changePassword {
			fmt.Print("Şifreler uyuşmuyor... Şifre değiştirilemedi.")
			log.SetOutput(logFile)
			message := " Şifre değiştirme İşlemi : BAŞARISIZ , "    
			log.Println(message , userName)
			UserPanel(userName , passwd)
			return

		} else if changePassword == ChangePasswordAgain {

			if _, err := os.Stat("Users.json"); err == nil {
				fileData, err := os.ReadFile("Users.json")
				checkError(err)
				json.Unmarshal(fileData, &users)
			}

			for i, u := range users {
				if u.Username == userName {
					users[i].Password = changePassword 
					fmt.Println("Şifre başarıyla değiştirildi.")
					log.SetOutput(logFile)
					message := " Şifre Değiştirme İşlemi : BAŞARILI , "    
					log.Println(message, userName)
				}
			}
			
			
			outFile, err := os.OpenFile("Users.json", os.O_WRONLY|os.O_TRUNC|os.O_CREATE, 0644)
   			checkError(err)
    		defer outFile.Close()

    		encoder := json.NewEncoder(outFile)
    		err = encoder.Encode(users) 
    		checkError(err)
			UserPanel(userName , passwd)


		}



	} else if secim2 == 0 {
		fmt.Print("Çıkış yapılıyor...")
		log.SetOutput(logFile)
		message := " Kullanıcısı Çıkış Yaptı. "    
		log.Println(userName , message)
		os.Exit(1)
	}
	


}

func main() {
	var secim int
	var err error

	


	logFile, err = os.OpenFile("Log.txt", os.O_CREATE|os.O_WRONLY|os.O_APPEND, 0644)
    if err != nil {
        checkError(err)
        return
    }

	
	
	





	fmt.Print("\n \n ***************************************[ HOŞGELDİNİZ ]************************************************ \n")
	fmt.Print("Lüten Seçenekleri belirtin \n 1-) Giriş Yap \n 2-) Kaydol \n SEÇİM: ")
	fmt.Scan(&secim)
	
	for secim != 1 && secim != 2 {
		fmt.Print("Lütfen 1 veya 2 girin: ")
		fmt.Scan(&secim)
	}
	if secim == 1 {
		login() 
	} else if secim == 2 {
		register()

	}
  
}
