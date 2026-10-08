const LANGUAGES = ["Urdu", "Sindhi", "Punjabi", "Balochi", "Pashto", "English"];
const GENRES = ["Pop", "Rock", "Folk", "Sufi", "Hip Hop", "R&B", "Electronic"];

const ERAS = [
  { label: "2000–2005", min: 2000, max: 2005 },
  { label: "2005–2010", min: 2005, max: 2010 },
  { label: "2010–2015", min: 2010, max: 2015 },
  { label: "2015–2020", min: 2015, max: 2020 },
  { label: "2020–2025", min: 2020, max: 2025 },
  { label: "2026 — Latest", min: 2026, max: 2026 },
];

const ARTISTS = [
  { id: "atif-aslam", name: "Atif Aslam", language: "Urdu", followers: "8.4M", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/1/1c/Atif_Aslam_2017.jpg/640px-Atif_Aslam_2017.jpg" },
  { id: "ali-zafar", name: "Ali Zafar", language: "Urdu", followers: "6.1M", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Ali_Zafar.jpg/640px-Ali_Zafar.jpg" },
  { id: "asim-azhar", name: "Asim Azhar", language: "Urdu", followers: "1.8M", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Asim_Azhar.jpg/640px-Asim_Azhar.jpg" },
  { id: "talha-anjum", name: "Talha Anjum", language: "Urdu", followers: "1.5M", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Talha_Anjum.jpg/640px-Talha_Anjum.jpg" },
  { id: "abdul-hannan", name: "Abdul Hannan", language: "Urdu", followers: "1.2M", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Abdul_Hannan.jpg/640px-Abdul_Hannan.jpg" },

  { id: "ali-baba", name: "Ali Baba", language: "Balochi", followers: "980K", image: "assets/images/artist-placeholder.svg" },
  { id: "wahab-bugti", name: "Wahab Bugti", language: "Balochi", followers: "720K", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/5/52/Wahab_Bugti.jpg/640px-Wahab_Bugti.jpg" },
  { id: "momin-khan", name: "Momin Khan", language: "Balochi", followers: "420K", image: "assets/images/artist-placeholder.svg" },
  { id: "behram-baloch", name: "Behram Baloch", language: "Balochi", followers: "390K", image: "assets/images/artist-placeholder.svg" },
  { id: "nazir-ahmad", name: "Nazir Ahmed", language: "Balochi", followers: "310K", image: "assets/images/artist-placeholder.svg" },

  { id: "abrarul-haq", name: "Abrar-ul-Haq", language: "Punjabi", followers: "2.6M", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/Abrar-ul-Haq.jpg/640px-Abrar-ul-Haq.jpg" },
  { id: "arif-lohar", name: "Arif Lohar", language: "Punjabi", followers: "1.9M", image: "assets/images/artist-placeholder.svg" },
  { id: "nusrat-fateh-ali-khan", name: "Nusrat Fateh Ali Khan", language: "Punjabi", followers: "7.2M", image: "assets/images/artist-placeholder.svg" },
  { id: "sajjad-ali", name: "Sajjad Ali", language: "Punjabi", followers: "2.1M", image: "assets/images/artist-placeholder.svg" },
  { id: "malkoo", name: "Malkoo", language: "Punjabi", followers: "890K", image: "assets/images/artist-placeholder.svg" },

  { id: "alamgir", name: "Alamgir", language: "Sindhi", followers: "610K", image: "assets/images/artist-placeholder.svg" },
  { id: "sanam-marvi", name: "Sanam Marvi", language: "Sindhi", followers: "980K", image: "assets/images/artist-placeholder.svg" },
  { id: "mai-dhai", name: "Mai Dhai", language: "Sindhi", followers: "540K", image: "assets/images/artist-placeholder.svg" },
  { id: "shazia-khushk", name: "Shazia Khushk", language: "Sindhi", followers: "720K", image: "assets/images/artist-placeholder.svg" },
  { id: "allan-faqir", name: "Allan Fakir", language: "Sindhi", followers: "480K", image: "assets/images/artist-placeholder.svg" },

  { id: "gul-panra", name: "Gul Panra", language: "Pashto", followers: "1.7M", image: "assets/images/artist-placeholder.svg" },
  { id: "haroon-bacha", name: "Haroon Bacha", language: "Pashto", followers: "520K", image: "assets/images/artist-placeholder.svg" },
  { id: "sardar-ali-takkar", name: "Sardar Ali Takkar", language: "Pashto", followers: "610K", image: "assets/images/artist-placeholder.svg" },
  { id: "nazir-jan", name: "Nazir Jan", language: "Pashto", followers: "330K", image: "assets/images/artist-placeholder.svg" },
  { id: "zeb-bangash", name: "Zeb Bangash", language: "Pashto", followers: "790K", image: "assets/images/artist-placeholder.svg" },

  { id: "justin-bieber", name: "Justin Bieber", language: "English", followers: "305M", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/0/0b/Justin_Bieber_in_2015.jpg/640px-Justin_Bieber_in_2015.jpg" },
  { id: "alan-walker", name: "Alan Walker", language: "English", followers: "46M", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Alan_Walker.jpg/640px-Alan_Walker.jpg" },
  { id: "billie-eilish", name: "Billie Eilish", language: "English", followers: "119M", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Billie_Eilish_2023.jpg/640px-Billie_Eilish_2023.jpg" },
  { id: "ed-sheeran", name: "Ed Sheeran", language: "English", followers: "105M", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Ed_Sheeran_2018.jpg/640px-Ed_Sheeran_2018.jpg" },
  { id: "the-weeknd", name: "The Weeknd", language: "English", followers: "96M", image: "https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/The_Weeknd_Cannes_2023.png/640px-The_Weeknd_Cannes_2023.png" },
];

const seedTitles = {
  "Atif Aslam": ["Aadat", "Tera Hone Laga Hoon", "Doorie", "Jeena Jeena", "Dil Diyan Gallan", "Tajdar-e-Haram", "Pehli Dafa", "Tu Jaane Na", "Woh Lamhe Woh Baatein", "Main Rang Sharbaton Ka", "Jeene Laga Hoon", "Dil Darbadar", "O Saathi", "Kuch Is Tarah", "Rangrez"],
  "Ali Zafar": ["Channo", "Jhoom", "Madhubala", "Lahore Se Aaya", "Urain Ge", "Sajni", "Masti", "Item Number", "Rockstar", "Huqa Pani", "Teefa in Trouble", "Ullu Da Pattha", "Larsha Pekhawar", "Dastan-e-Ishq", "Jee Dhoondta Hai"],
  "Asim Azhar": ["Habibi", "Jo Tu Na Mila", "Ghalat Fehmi", "Dard", "Soneya", "Bardasht", "Tum Tum", "Samjho Na", "Chal Jhooti", "Kyun", "Tera Woh Pyar", "Soneya Re", "Mitti", "Yaad", "Nazar"],
  "Talha Anjum": ["Gumaan", "Downers at Dusk", "Agency", "Melancholy", "Afsanay", "Secrets", "Kaun Talha", "Happy Hour", "Glass Half Full", "Open Letter", "Talk To Me", "Balli Aur Mein", "Khana Badosh", "Muntazir", "4AM in Karachi"],
  "Abdul Hannan": ["Iraaday", "Bikhra", "Nahi Milta", "Sukoon", "Meri Jaan", "Kahani", "Azaadi", "Raatein", "Dastan", "Khaab", "Faasla", "Khwahish", "Lamha", "Raasta", "Roshni"],

  "Ali Baba": ["Balochi Watan", "Laila", "Biya", "Sajni", "Dilbar", "Mast", "Khwab", "Roshni", "Hawa", "Gul", "Sohni", "Mera Dil", "Dost", "Safar", "Pyar"],
  "Wahab Bugti": ["Kana Yaari Live", "Balochi Nights", "Maa", "Dilbar", "Sajni", "Koh-e-Murad", "Roshni", "Biya", "Manzil", "Dildar", "Gul", "Aas", "Safar", "Dost", "Watan"],
  "Momin Khan": ["Zari Watan", "Kounj Ghar", "Mehrbani", "Gwadar", "Hingol", "Makran", "Sarhad", "Dosti", "Janbaz", "Seeb", "Hoor", "Shauq", "Bolan", "Kirthar", "Dara"],
  "Behram Baloch": ["Sipah", "Lasbela", "Awaran", "Panjgur", "Kharan", "Mashkel", "Naukabad", "Abreshum", "Kharosh", "Gichki", "Halam", "Umran", "Mohabbat", "Ghairat", "Yaar"],
  "Nazir Ahmed": ["Baloch Qaum", "Mulla Faqir", "Nawab Akbar", "Mir Chakar", "Koh-e-Suleman", "Shahbaz", "Chiltan", "Mekran Coast", "Dera Bugti", "Rakshan", "Khuzdar", "Kalat", "Surab", "Hub River", "Ziarat"],

  "Abrar-ul-Haq": ["Billo De Ghar", "Nach Punjaban", "Preeto", "Sanu Tere Naal Pyar", "Asaan Jana Mall-o-Mall", "Bhangra Pa Lai", "Nachan Main Udeekan", "Kurti", "Pardesi", "Mahi Mahi", "Sohni Lagdi", "Mundiya", "Jeevay Jeevay", "Aaja Ni Aaja", "Tere Bin"],
  "Arif Lohar": ["Jugni", "Saari Raat Jaga", "Alif Allah Chambey Di Booti", "O Dil", "Mera Dil", "Sohna Mahi", "Taj Mahal", "Dhola", "Mahi", "Bachpan Ka Pyar", "Jhoomer", "Gallan Teriyan", "Mitran Di Chatri", "Mundriyan", "Rabba Mere"],
  "Nusrat Fateh Ali Khan": ["Tere Bin Nahin Lagda", "Mera Piya Ghar Aaya", "Dam Mast Qalandar", "Allah Hoo", "Mast Qalandar", "Afreen Afreen", "Piya Re Piya Re", "Sanson Ki Mala Pe", "Tumhein Dillagi", "Jhoom Jhoom", "Dil Har Har Aaya", "Man Kunto Maula", "Tere Ishq Mein", "Haq Ali", "Kinaray"],
  "Sajjad Ali": ["Baber", "Dil Dhadakne Do", "Soneya", "Sangdil", "Tera Chehra", "Bhola Bhal", "Janaan", "Kaisay Bataan", "Mera Dil", "Pyar", "Zindagi", "Tum", "Laili", "Bharosa", "Chann"],
  "Malkoo": ["Sakriya", "Dhola", "Sohni", "Mahi Ve", "Mukhra", "Ranjha", "Heer", "Do Qadam", "Mera Dil", "Putt Jatt Da", "Saiyyan", "Tera Na", "Gallan", "Botal", "Dilbar"],

  "Alamgir": ["Sindhi Sajan", "Mor", "Sajjan Mela", "Yaad Sajan", "Mahi Sajan", "Mela Sindh", "Sindhu Paar", "Darya Kinare", "Sathi", "Chand Sitara", "Meharbani", "Sindhi Choli", "Ae Maula", "Dua Mange", "Sajra"],
  "Sanam Marvi": ["Haq Ali Ali Haq", "Morr Piya", "Yaar Ko Hamne", "Ae Ri Sakhi", "Nindo Nindo", "Tuhinji Muhinji", "Sain", "Sindhi Sufi", "Zulfan", "Maat", "Piyar", "Sajjan", "Dam Mast", "Meharban", "Sawari"],
  "Mai Dhai": ["Jhulelal", "Sindhu Darya", "Teejay", "Morinda", "Sughri", "Laali", "Hingh", "Amar Akhir", "Dhola Maa", "Sadqay", "Khaan", "Sajri", "Watan Sindh", "Zindagi Rang", "Riti"],
  "Shazia Khushk": ["Chan Chit", "Mehari", "Sohni Moomal", "Marvi", "Umar Marvi", "Dil Deed", "Sang", "Mati", "Pyaas", "Bhati", "Moomal Rano", "Sassi Punnu", "Jhok Ranjha", "Sindhi Wara", "Ho Jamalo"],
  "Allan Fakir": ["Allah Hoo Allah Hoo", "Aaye Mowla", "Peer Mitha", "Sindhri", "Dama Dama", "Lal Shahbaz", "Sufi", "Bhaari", "Dilagri", "Bewara", "Misaal", "Noor", "Rehbar", "Dua", "O Moula"],

  "Gul Panra": ["Janan", "Sanga Janan", "Sta De Zargi Pata", "Toor Da Raqse", "Inziar", "Adam Khan Durkhanai", "Shin Karam", "Wajdan", "Zenda", "Mina", "Khwab-e-Pashto", "Shu Da", "Za Ra Di", "Da Zamung Zargay", "Razra"],
  "Haroon Bacha": ["Kandahari", "Mashooq", "Rabab", "Da Pukhto", "Mundari", "Bela", "Sok Wai", "Yada", "Stargay", "Pukhtana", "Zaray", "Naghme", "Chai Chai", "Wiyar", "Gharzangai"],
  "Sardar Ali Takkar": ["Zama Da Yara De", "Da Yad Yad", "Sta Pukhto Ra Bar", "Mina Janana", "Da Zra Baga", "Yara", "Sok Rah De", "Watan Pukhto", "Zama Bela", "Da Kho Yama", "Naway Watan", "Mena", "Pukhtana Raqs", "Naghme Wala", "Da Sangar De"],
  "Nazir Jan": ["Yara Yara", "Zar Da Mena", "Pa Zra De", "Shah Gul", "Da Damana", "Da Sanghra", "Haq Bahak", "Khan Gara", "Sta Da Zargi", "Pukhto Adab", "Naway Karak", "Da Kho Pukhto", "Mera Mena", "Zulmi Wafadar", "Khyber Pakhtunkhwa"],
  "Zeb Bangash": ["Paimona", "Dilruba", "Imaan Ka Safar", "Kaghaz Ka Jahan", "Janoon", "Banoori", "Sango", "Da Zra Mina", "Pukhto Jan", "Yara Zeb", "Mundri Zi", "Sawal", "Gulaal", "Sufi Zeb", "Nazra"],

  "Justin Bieber": ["Baby", "Sorry", "Love Yourself", "Peaches", "Ghost", "Stay", "What Do You Mean?", "Yummy", "Anyone", "Intentions", "Company", "Hold On", "Holy", "Purpose", "One Time"],
  "Alan Walker": ["Faded", "Alone", "The Spectre", "Darkside", "Diamond Heart", "On My Way", "Sing Me to Sleep", "Lily", "Heading Home", "Force", "Ignite", "All Falls Down", "Different World", "Play", "World of Walker"],
  "Billie Eilish": ["Ocean Eyes", "bad guy", "lovely", "Happier Than Ever", "Therefore I Am", "when the party's over", "everything i wanted", "my future", "BIRDS OF A FEATHER", "Lunch", "What Was I Made For?", "NDA", "Your Power", "idontwannabeyouanymore", "bury a friend"],
  "Ed Sheeran": ["Shape of You", "Perfect", "Thinking Out Loud", "Photograph", "Castle on the Hill", "Galway Girl", "Bad Habits", "Shivers", "I Don't Care", "Happier", "The A Team", "Lego House", "Give Me Love", "Afterglow", "Overpass Graffiti"],
  "The Weeknd": ["Blinding Lights", "Starboy", "Save Your Tears", "The Hills", "Can't Feel My Face", "Call Out My Name", "Die For You", "After Hours", "In Your Eyes", "Heartless", "Earned It", "I Feel It Coming", "Often", "The Morning", "Wicked Games"],
};

const fallbackTitles = ["Midnight Echo", "Golden Hour", "Afterglow", "Velvet Roads", "Moonlit Drive", "Silent City", "Wild Hearts", "Paper Skies", "Neon Rain", "Slow Motion", "Open Windows", "Falling Lights", "Old Stories", "New Beginnings", "Last Call"];

const coverPool = [
  "https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=900&q=85",
  "https://images.unsplash.com/photo-1524368535928-5b5e00ddc76b?auto=format&fit=crop&w=900&q=85",
  "https://images.unsplash.com/photo-1501386761578-eac5c94b800a?auto=format&fit=crop&w=900&q=85",
  "https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&w=900&q=85",
  "https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&w=900&q=85",
  "https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=900&q=85",
  "https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?auto=format&fit=crop&w=900&q=85",
  "https://images.unsplash.com/photo-1521337581100-8ca9a73a5f79?auto=format&fit=crop&w=900&q=85",
];

function makeTracks() {
  const tracks = [];

  ARTISTS.forEach((artist, artistIndex) => {
    const titles = seedTitles[artist.name] || fallbackTitles;
    const years = [2002, 2004, 2007, 2009, 2012, 2014, 2016, 2018, 2020, 2021, 2022, 2023, 2024, 2025, 2026];
    const genres =
      artist.language === "English"
        ? ["Pop", "Electronic", "R&B", "Rock", "Hip Hop"]
        : ["Pop", "Sufi", "Rock", "Folk", "Hip Hop"];

    titles.forEach((title, titleIndex) => {
      tracks.push({
        id: `${artist.id}-${titleIndex + 1}`,
        title: title,
        artistId: artist.id,
        artist: artist.name,
        language: artist.language,
        genre: genres[(titleIndex + artistIndex) % genres.length],
        year: years[titleIndex],
        rating: (4.1 + ((titleIndex + artistIndex) % 9) / 10).toFixed(1),
        cover: coverPool[(titleIndex + artistIndex) % coverPool.length],
      });
    });
  });

  return tracks;
}

const TRACKS = makeTracks();

function getArtist(id) {
  return ARTISTS.find((artist) => artist.id === id);
}

const ALBUM_LANGUAGE_ORDER = ["Urdu", "Sindhi", "Punjabi", "Pashto", "Balochi", "English"];

function getLanguageArtists(language) {
  return ARTISTS.filter((artist) => artist.language === language);
}

const ALBUM_COVER_OVERRIDES = {
  "Urdu": "https://images.pexels.com/photos/36441741/pexels-photo-36441741.jpeg?auto=compress&cs=tinysrgb&w=800",
  "Sindhi": "https://images.pexels.com/photos/9142091/pexels-photo-9142091.jpeg?auto=compress&cs=tinysrgb&w=800",
  "Punjabi": "https://images.pexels.com/photos/15634127/pexels-photo-15634127.jpeg?auto=compress&cs=tinysrgb&w=800",
  "Pashto": "https://images.pexels.com/photos/19957638/pexels-photo-19957638.jpeg?auto=compress&cs=tinysrgb&w=800",
  "Balochi": "https://images.pexels.com/photos/35034129/pexels-photo-35034129.jpeg?auto=compress&cs=tinysrgb&w=800",
  "English": "https://images.pexels.com/photos/14828524/pexels-photo-14828524.jpeg?auto=compress&cs=tinysrgb&w=800",
};

const ALBUM_RATINGS = {
  "Urdu": 4.9,
  "Sindhi": 4.7,
  "Punjabi": 4.8,
  "Pashto": 4.6,
  "Balochi": 4.5,
  "English": 4.4,
};

function getLanguageCover(language) {
  if (ALBUM_COVER_OVERRIDES[language]) return ALBUM_COVER_OVERRIDES[language];

  const artists = getLanguageArtists(language);
  const withPhoto = artists.find((artist) => !artist.image.includes("placeholder"));
  return (withPhoto || artists[0] || {}).image || "assets/images/artist-placeholder.svg";
}

const ALBUM_INSTRUMENTS = {
  "Urdu": "assets/images/instruments/urdu.jpg",
  "Sindhi": "assets/images/instruments/sindhi.jpg",
  "Punjabi": "assets/images/instruments/punjabi.jpg",
  "Pashto": "assets/images/instruments/pashto.jpg",
  "Balochi": "assets/images/instruments/balochi.jpg",
  "English": "assets/images/instruments/english.jpg",
};

function getLanguageInstrument(language) {
  return ALBUM_INSTRUMENTS[language] || getLanguageCover(language);
}

function shuffle(items) {
  const arr = [...items];

  for (let i = arr.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [arr[i], arr[j]] = [arr[j], arr[i]];
  }

  return arr;
}

function filterTracks({ language = "", genre = "", artistId = "", era = "" } = {}) {
  let result = [...TRACKS];

  if (language) result = result.filter((track) => track.language === language);
  if (artistId) result = result.filter((track) => track.artistId === artistId);
  if (genre) result = result.filter((track) => track.genre === genre);

  if (era) {
    const eraRange = ERAS.find((item) => item.label === era);
    if (eraRange) {
      result = result.filter((track) => track.year >= eraRange.min && track.year <= eraRange.max);
    }
  }

  if (artistId) return result.slice(0, 15);
  if (language || era) return shuffle(result).slice(0, 15);
  return result;
}

function trackCard(track, mode = "music", isLatest = false) {
  const artist = getArtist(track.artistId);
  const badges = [];

  if (track.year >= 2024) {
    badges.push('<span class="type-badge new">NEW</span>');
  }

  return `
    <article class="track-card">
      <div class="cover-wrap">
        <img src="${track.cover}" alt="${track.title} cover" loading="lazy">
        <button class="play-fab" data-play="${track.id}" aria-label="Play ${track.title}">▶</button>
        ${badges.join("")}
      </div>
      <div class="track-body">
        <div class="track-title-row">
          <div>
            <h3>${track.title}</h3>
            <p>${track.artist} · ${track.language}</p>
          </div>
          <span class="year-pill">${track.year}</span>
        </div>
        <div class="rating" aria-label="Rating ${track.rating} out of 5">
          <span>★★★★★</span><b>${track.rating}</b>
        </div>
        <div class="track-actions">
          <button class="text-btn" data-play="${track.id}">Play</button>
          <button class="icon-btn rate-btn" title="Rate this song">☆</button>
        </div>
      </div>
    </article>
  `;
}

function artistCard(artist) {
  return `
    <a class="artist-card" href="artist.php?id=${artist.id}">
      <div class="artist-image-wrap">
        <img
          src="${artist.image}"
          alt="${artist.name}"
          loading="lazy"
          onerror="this.src='assets/images/artist-placeholder.svg'"
        >
      </div>
      <div class="artist-card-meta">
        <h3>${artist.name}</h3>
        <p>${artist.language}</p>
      </div>
    </a>
  `;
}
