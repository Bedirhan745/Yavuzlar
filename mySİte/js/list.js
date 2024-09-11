
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



const listeElementi = document.getElementById("listem");


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



listedenCagir();






