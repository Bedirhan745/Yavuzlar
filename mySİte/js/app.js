const sorular = [
    
    {
        name: "Soru 1",
        class: "kolay",
        sorum: "Bazı Tarihçiler tarafından Osmanlının ilk padişahı olarak adlandırılan, düzenli ordu kurmasıyla Bursa'yı Fetheden Padişahımız kimdir?" ,
        cevaplar: [
            {text: "Ertuğrul Gazi" , correct:false },
            {text: "Osman Gazi" , correct:false },
            {text: "Orhan Gazi" , correct:true  },
            {text: "I. Murat " , correct:false },

        ]
    },
  
    {
        name: "Soru 2",
        class: "kolay",
        sorum: "javada a= 5, b=7 için system.out.prtinln(a + b) kaçı yazdırır?" ,
        cevaplar: [
            {text: "10" , correct:false },
            {text: "11" , correct:false },
            {text: "12" , correct:true  },
            {text: "13" , correct:false },

        ]
    },
    {
        name: "Soru 3",
        class: "kolay",
        sorum: "javada a= 5, b=7 için system.out.prtinln('a' + 'b') kaçı yazdırır?" ,
        cevaplar: [
            {text: "10" , correct:false },
            {text: "11" , correct:false },
            {text: "12" , correct:false },
            {text: "57" , correct:true  },

        ]
    },
    {
        name: "Soru 4",
        class: "orta",
        sorum: "Dünyadaki en küçük kıta hangisidir" ,
        cevaplar: [
            {text: "Avustralya" , correct:true  },
            {text: "asya" , correct:false },
            {text: "Avrupa" , correct:false },
            {text: "Afrika" , correct:false },

        ]
    },
    {
        name: "Soru 5",
        class: "zor",
        sorum: "ABCD X 4 = DCBA  ise  ABCD nin rakamları toplamı aşağıdakilerden hangisidir? " ,
        cevaplar: [
            {text: "15" , correct:false  },
            {text: "16" , correct:false },
            {text: "17" , correct:false },
            {text: "18" , correct:true },

        ]
    },

    {
        name: "Soru 6",
        class: "orta",
        sorum: "Aşaıdakilerden hangisi I. beylikler dönemindeki bir beylik değildir?" ,
        cevaplar: [
            {text: "Çaka Beyliği" , correct:false  },
            {text: "Artuklu Beyliği" , correct:false },
            {text: "Karesioğulları Beyliği" , correct:true },
            {text: "Saltuklu Beyliği" , correct:false },

        ]
    },
    {
        name: "Soru 7",
        class: "zor",
        sorum: " 'Aşk nerden nereye' adlı şarkıyı hangi müzik grubu bestelemiştir?" ,
        cevaplar: [
            {text: "Gripin" , correct:true  },
            {text: "Seksendört" , correct:false },
            {text: "Mavi Işıklar" , correct:false },
            {text: "Model" , correct:false },

        ]
    },
    {
        name: "Soru 8",
        class: "zor",
        sorum: "Haziran 2010'da varlığı açığa çıkan, İran'ın Buşehr ve Natanz'daki nükleer tesislerini etkileyen, ve arkasında  ABD ve İsrail'in olduğu düşünülen virüsün ismi ile türü hangi şıkta doğru olarak verilmiştir?" ,
        cevaplar: [
            {text: "Conficker , Worm" , correct:false  },
            {text: "Conficker , Trojan" , correct:false },
            {text: "Stuxnet , Worm" , correct:true },
            {text: "Stuxnet , Trojan" , correct:false },

        ]
    },
    {
        name: "Soru 9",
        class: "orta",
        sorum: " Standart bir duvar saatinde, saat kaç iken akrep ve yelkovan arası 180 dereceyi gösterir?" ,
        cevaplar: [
            {text: "12:30" , correct:false  },
            {text: "15:45" , correct:false },
            {text: "18:00" , correct:true},
            {text: "09:15" , correct:false },

        ]
    },
    {
        name: "Soru 10",
        class: "orta",
        sorum: " Savaş alanında ölen tek Osmanlı padişahı aşağıdakilerden hangisidir?" ,
        cevaplar: [
            {text: "I. Murat" , correct:true  },
            {text: "II. Murat" , correct:false },
            {text: "I. Mehmet" , correct:false },
            {text: "II. Mehmet" , correct:false },

        ]
    }
  ];
  

  
  


const soruElementi = document.getElementById("soru"); /* kullandım */
const cevapButon = document.getElementById("cevaplar");/* kullandım */
const nextButton = document.getElementById("next-btn");/* kullandım */
const tebrikMessage = document.getElementById("tebrikler"); /* kullandım */
const soruSayisiElementi = document.getElementById("quizOrder"); /* kullandım */
const zorlukElementi = document.getElementById("sorubar");
const dogruSayiElementi = document.getElementById("dogruSayisi");/* kullandım */
const puanElementi = document.getElementById("puan"); /* kullandım */
const finishButtonElement = document.getElementById("finish_btn"); /* kullandım */
const randomelement = document.getElementById("index_buton");





let simdikiSoruIndex = 0; 
let dogruSayisi = 0;
let toplamSoru = 0;

/* randomelement.addEventListener("click" , randomUret);

function randomUret () {
    let simdikiSoruIndex = simdikiSoruIndex + Math.floor(Math.random() * 10)  //  hocam random sayı üretmesini istiyorum ama kodu açtığımda js yi bozuyor. araştırdım sonucu bulamadım.
} */

for (let i = 0; i <= sorular.length; i++) {
    toplamSoru= i; 
}


function listedenCagir() {
    resetState2();
    sorular.forEach(x => {
       
        const buton = document.createElement("button");
        buton.innerHTML = x.name;
        buton.classList.add("sorular__");
        listeElementi.appendChild(buton);
    });
}

function resetState2() {

    while(listeElementi.firstChild) {
    
        listeElementi.removeChild(listeElementi.firstChild)
    }
}


function startQuestionApp () {
    simdikiSoruIndex = 0;
    dogruSayisi = 0;
    nextButton.innerHTML = "Sonraki";
    soruCağir ();
}



function soruCağir () {
    resetState(); 
    let simdikiSoru = sorular [simdikiSoruIndex];
    let soruNo = simdikiSoruIndex + 1 ;
    soruElementi.innerHTML = soruNo + "-) " + simdikiSoru.sorum;
        soruSayisiElementi.innerHTML = soruNo + "/" + toplamSoru;
        if(simdikiSoru.class === "zor"){ // Zorluk seviyesi ekliorum.
            zorlukElementi.style.background = "#4d0500";
        }else if (simdikiSoru.class === "kolay"){
            zorlukElementi.style.background = "#124d00";
        } else {
            zorlukElementi.style.background = "#cdb132";
        }
        
        simdikiSoru.cevaplar.forEach(cevap => {
        const button = document.createElement("button");
        button.innerHTML = cevap.text;
        button.classList.add("text");
        cevapButon.appendChild(button);
        if(cevap.correct) {
            button.dataset.correct = cevap.correct;
        }
        
        button.addEventListener("click", selectSoru); 
    });

}

function resetState() {

    while(cevapButon.firstChild) {
        nextButton.style.display = "none";
        cevapButon.removeChild(cevapButon.firstChild)
    }
}

function selectSoru (x) {
    const seciliButon= x.target;
    const dogruMu= seciliButon.dataset.correct === "true";

    if(dogruMu) {
        seciliButon.classList.add("dogru");
        dogruSayisi++;
    } else {
        seciliButon.classList.add("yanlis");
    }

    Array.from(cevapButon.children).forEach(button => {
       if(button.dataset.correct === "true") {
        button.classList.add("dogru");
       }
       button.disabled = "true";
    });
     nextButton.style.display = "block"; 
}

function skorGoster() {
resetState();
soruElementi.innerHTML = `${simdikiSoruIndex} sorudan ${dogruSayisi} soruyu doğru bildin!`
nextButton.innerHTML = "Sonuç Tablosu";
nextButton.style.display = "block"; 
dogruCağir();
puanCağir();
 nextButton.addEventListener("click" , tebrikMesaji)
}
function dogruCağir() {
    dogruSayiElementi.innerHTML = `${dogruSayisi}`
}
function puanCağir() {
let sonuc = (dogruSayisi/simdikiSoruIndex)*100;
puanElementi.innerHTML = `${sonuc}`
}
function tebrikMesaji () {
    tebrikMessage.style.display = "flex";
    finishButtonElement.addEventListener("click",sakla )
}
function sakla() {
    tebrikMessage.style.display = "none";
    window.location.href = 'file:///C:/Users/Bedirhan/Desktop/myS%C4%B0te/index.html';
}

function handleNextButton() {

    simdikiSoruIndex++;
    if(simdikiSoruIndex < sorular.length) {
        soruCağir();
    } else {
        skorGoster();
    }
}

nextButton.addEventListener("click" , () => {
    if (simdikiSoruIndex < sorular.length) {
        handleNextButton();
        
    }else {
        startQuestionApp();
    }

});
    

startQuestionApp();


