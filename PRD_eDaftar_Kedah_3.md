# Product Requirements Document (PRD)
# Sistem Pendaftaran Kursus & Mesyuarat Penjawat Awam Negeri Kedah
## "e-DAFTAR Kedah"

---

| Item | Butiran |
|------|---------|
| Nama Produk | e-DAFTAR Kedah |
| Versi PRD | 1.4 |
| Tarikh | 1 Mei 2026 |
| Status | Draf untuk Semakan (dikemas kini dengan modul RBAC & Pengurusan Akses) |
| Pemilik Produk | _(Untuk diisi)_ |
| Pemegang Kepentingan | Pejabat Setiausaha Kerajaan Negeri Kedah, Jabatan-jabatan Negeri, INTAN/INSAN, BPM Negeri |

---

## 1. Ringkasan Eksekutif

e-DAFTAR Kedah ialah sistem berasaskan web dan mudah alih yang membolehkan jabatan-jabatan kerajaan negeri Kedah mendaftarkan kursus, latihan, taklimat dan mesyuarat secara berpusat, menjana **Kod QR unik** bagi setiap sesi, dan merekodkan kehadiran penjawat awam secara automatik melalui imbasan QR. Sistem ini menggantikan proses kehadiran manual berasaskan kertas (borang tandatangan) yang sukar diaudit, terdedah kepada manipulasi, dan menyukarkan penjanaan laporan.

Hasil utama yang dijangka: pengurangan masa pendaftaran kehadiran sebanyak 80%, ketepatan rekod kehadiran 100%, dan keupayaan menjana laporan kehadiran masa nyata untuk tujuan penilaian prestasi (LNPT) dan audit.

---

## 2. Latar Belakang dan Pernyataan Masalah

Pada masa ini, kebanyakan jabatan negeri Kedah masih bergantung pada borang kehadiran bercetak yang ditandatangani peserta semasa kursus atau mesyuarat. Pendekatan ini menimbulkan beberapa kelemahan operasi yang ketara. Pertama, borang kertas mudah hilang, koyak atau rosak, dan urus setia perlu memasukkan semula data ke dalam Excel secara manual selepas sesi tamat — proses yang memakan masa dan terdedah kepada kesilapan transkripsi. Kedua, pengesahan kehadiran sebenar sukar dilakukan kerana tandatangan boleh ditiru atau diisi pihak ketiga ("tandatangan ganti"). Ketiga, pegawai atasan dan pihak audit tidak dapat melihat status kehadiran secara masa nyata, menyebabkan keputusan operasi terjejas. Keempat, peserta kerap terlupa membawa atau menerima sijil kehadiran, dan jabatan menerima banyak permintaan susulan.

Selain itu, jabatan-jabatan berbeza menggunakan templat dan kaedah rekod yang tidak seragam, menyukarkan pelaporan peringkat negeri kepada Pejabat SUK atau MAMPU. Sistem berpusat dengan pengesahan digital melalui QR akan menyelesaikan masalah ini secara holistik.

---

## 3. Objektif Produk

Objektif utama e-DAFTAR Kedah adalah:

1. **Mendigitalisasikan** keseluruhan kitaran hayat acara — daripada pendaftaran acara, pengundangan peserta, pengesahan kehadiran, hingga penjanaan sijil dan laporan.
2. **Memastikan integriti rekod kehadiran** melalui pengesahan QR yang berkaitan dengan identiti pengguna sebenar (No. KP / No. Pekerja).
3. **Membolehkan pelaporan masa nyata** kepada pengurusan jabatan dan pemegang kepentingan negeri.
4. **Mengurangkan beban pentadbiran** urus setia sebanyak sekurang-kurangnya 60% dalam tempoh 6 bulan pertama selepas pelancaran penuh.
5. **Mematuhi** Akta Perlindungan Data Peribadi 2010 (PDPA), garis panduan keselamatan ICT MAMPU, dan polisi pengkomputeran kerajaan negeri Kedah.

---

## 4. Skop Sistem

### 4.1 Dalam Skop (In-Scope)

Sistem akan menyokong pendaftaran dan pengurusan acara berformat kursus, bengkel, taklimat, mesyuarat, seminar dan latihan dalaman jabatan. Sistem akan mengendalikan pengguna daripada semua jabatan dan agensi di bawah Kerajaan Negeri Kedah, termasuk Pejabat Daerah dan Tanah, PBT, dan agensi negeri seperti PKNK, MBI, dan KEDA (jika dipersetujui). Modul terasnya merangkumi pengurusan pengguna, pendaftaran acara, penjanaan dan imbasan QR, kehadiran, notifikasi, laporan, dan sijil digital.

### 4.2 Luar Skop (Out-of-Scope) untuk Versi 1.0

- Pengurusan kewangan/tuntutan elaun peserta (akan disambungkan ke sistem sedia ada melalui API pada fasa kemudian)
- Sistem pembelajaran dalam talian (LMS) — sistem ini fokus pada acara bersemuka dan hibrid
- Penilaian prestasi peserta (kuiz, ujian)
- Integrasi dengan HRMIS pada peringkat awal (akan dilaksanakan dalam Fasa 3)

---

## 5. Pengguna Sasaran (Personas)

### Persona 1: Pn. Aminah – Penyelaras Latihan Jabatan
Pn. Aminah ialah Pegawai Tadbir Gred N32 di Bahagian Latihan sebuah jabatan. Beliau bertanggungjawab merancang dan menyelaras 8–15 kursus sebulan. Keperluan utamanya ialah cara cepat mendaftarkan acara, menjemput peserta, dan menghasilkan laporan kehadiran untuk laporan bulanan kepada Ketua Jabatan. Beliau cekap menggunakan komputer tetapi tidak teknikal.

### Persona 2: En. Faizal – Penjawat Awam Peserta
En. Faizal ialah Penolong Pegawai Tadbir Gred N29 yang menghadiri 3–6 kursus/mesyuarat sebulan. Beliau menggunakan telefon pintar Android. Keperluannya: cara mudah dan pantas untuk daftar masuk acara tanpa beratur menandatangani borang, dan akses kepada sijil kehadirannya untuk LNPT.

### Persona 3: Datuk Razak – Pengarah Jabatan
Datuk Razak ingin melihat papan pemuka ringkas tentang kehadiran kakitangannya pada kursus wajib (mis. kursus integriti, kursus ICT) dan menerima makluman jika kadar kehadiran rendah.

### Persona 4: Pn. Suhana – Pentadbir Sistem (Super Admin)
Pn. Suhana di Pejabat SUK mengawal selia konfigurasi sistem peringkat negeri, menguruskan akaun pentadbir jabatan, dan menjana laporan agregat untuk semua jabatan.

---

## 6. Senarai Ciri (Feature List)

Ciri-ciri sistem disusun mengikut keutamaan **MoSCoW** (Must, Should, Could, Won't).

| ID | Ciri | Keutamaan | Modul |
|----|------|-----------|-------|
| F-01 | Daftar masuk pengguna dengan No. KP/No. Pekerja & kata laluan | Must | Auth |
| F-02 | Pengesahan dua faktor (2FA) melalui OTP e-mel/SMS | Must | Auth |
| F-03 | Pengurusan profil pengguna (jabatan, jawatan, gred) | Must | Pengguna |
| F-04 | Pendaftaran acara baharu oleh pentadbir jabatan | Must | Acara |
| F-05 | Penjanaan Kod QR unik bagi setiap acara | Must | Acara |
| F-06 | QR statik (1 QR untuk seluruh acara) atau dinamik (QR berputar setiap 30 saat untuk anti-perkongsian) | Must | Acara |
| F-07 | Imbasan QR melalui aplikasi mudah alih atau pelayar web | Must | Kehadiran |
| F-08 | Pengesahan geolokasi semasa imbas (radius dari lokasi acara) | Should | Kehadiran |
| F-09 | Sokongan acara hibrid: pautan dalam talian + QR fizikal | Should | Acara |
| F-10 | Jemputan automatik melalui e-mel | Must | Notifikasi |
| F-11 | Peringatan H-1 dan H-1jam | Should | Notifikasi |
| F-12 | Papan pemuka kehadiran masa nyata | Must | Laporan |
| F-13 | Eksport laporan ke PDF/Excel | Must | Laporan |
| F-14 | Penjanaan sijil kehadiran digital (PDF) | Must | Sijil |
| F-15 | Tandatangan digital pada sijil | Should | Sijil |
| F-16 | Daftar log keluar (check-out) untuk audit tempoh sebenar | Could | Kehadiran |
| F-17 | Sokongan bahasa Malaysia & Inggeris | Must | Sistem |
| F-18 | API terbuka untuk integrasi dengan sistem jabatan | Could | Integrasi |
| F-19 | Mod luar talian terhad untuk imbas QR (sync apabila online) | Could | Mobile |
| F-20 | Pengurusan kuota peserta dan senarai menunggu | Should | Acara |
| F-21 | Permohonan gantian peserta sebelum acara (dengan kelulusan Penyelaras) | Must | Gantian |
| F-22 | Gantian walk-in di tempat acara dengan kelulusan kilat | Must | Gantian |
| F-23 | Mod gantian terbuka (mana-mana wakil dari jabatan yang sama) | Should | Gantian |
| F-24 | Audit log lengkap untuk setiap penggantian peserta | Must | Gantian |
| F-25 | Pautan kehadiran unik per peserta untuk acara dalam talian | Must | Acara Dalam Talian |
| F-26 | Auto-nyahaktif geolokasi untuk acara berjenis dalam talian | Must | Acara Dalam Talian |
| F-27 | Pengesahan kehadiran berterusan (random check-in) untuk sesi panjang | Should | Acara Dalam Talian |
| F-28 | Integrasi API dengan Zoom, Google Meet, MS Teams | Could | Acara Dalam Talian |
| F-29 | Sokongan acara hibrid dengan dwi-mekanisme kehadiran serentak | Must | Acara Dalam Talian |
| F-30 | Sokongan struktur acara induk dengan beberapa sesi (multi-day events) | Must | Sesi |
| F-31 | Konfigurasi sesi pagi/petang/malam per hari acara | Should | Sesi |
| F-32 | QR Code unik dan masa sah berasingan untuk setiap sesi | Must | Sesi |
| F-33 | Pengiraan kehadiran berdasarkan peratus sesi yang dihadiri | Must | Sesi |
| F-34 | Ambang sijil boleh dikonfigur per acara (mis. minimum 80% sesi) | Must | Sijil |
| F-35 | Gantian peserta per sesi (peserta hadir sebahagian, wakil ganti baki) | Should | Gantian |
| F-36 | Penjejakan jam latihan kumulatif per pengguna (untuk LNPT) | Must | Laporan |
| F-37 | Eksport rekod jam latihan tahunan dalam format LNPT standard | Must | Laporan |
| F-38 | Penanda sesi sebagai "Wajib" atau "Opsyenal" untuk pengiraan kelayakan sijil | Should | Sesi |
| F-39 | Sokongan acara siri (recurring) dengan pendaftaran berasingan setiap sesi | Could | Acara |
| F-40 | Sistem peranan berhierarki dengan 9+ peranan lalai sistem | Must | RBAC |
| F-41 | Kebenaran granular per modul/tindakan (mis. event.create, user.delete) | Must | RBAC |
| F-42 | Skop kebenaran terhad pada jabatan/PTJ (multi-tenancy) | Must | RBAC |
| F-43 | Pengguna boleh memegang lebih daripada satu peranan serentak | Must | RBAC |
| F-44 | Peranan tersuai (custom roles) boleh dicipta oleh Super Admin | Should | RBAC |
| F-45 | Pelantikan sementara/delegasi dengan tarikh tamat automatik | Should | RBAC |
| F-46 | Pelantikan pemangku jawatan (acting roles) | Should | RBAC |
| F-47 | Audit log lengkap untuk setiap perubahan peranan/kebenaran | Must | RBAC |
| F-48 | Antara muka self-service untuk pengguna lihat senarai kebenaran sendiri | Should | RBAC |
| F-49 | Antara muka pemilik acara (resource ownership) untuk Penyelaras urus acara sendiri | Must | RBAC |
| F-50 | Notifikasi automatik kepada pengguna apabila peranan/kebenaran berubah | Should | RBAC |

---

## 7. User Stories Terpilih

**US-01:** Sebagai **Penyelaras Latihan**, saya mahu mendaftarkan kursus baharu dengan butiran (tajuk, tarikh, lokasi, kuota, fasilitator) dan menjana QR sekali klik, supaya saya tidak perlu menyediakan borang kehadiran kertas.

**US-02:** Sebagai **Penjawat Awam**, saya mahu mengimbas QR di kaunter acara dengan telefon saya dan menerima pengesahan kehadiran serta-merta, supaya saya tidak perlu beratur menulis pada borang.

**US-03:** Sebagai **Penyelaras Latihan**, saya mahu melihat senarai peserta yang telah hadir secara masa nyata sepanjang acara, supaya saya boleh mengambil tindakan susulan jika peserta wajib belum tiba.

**US-04:** Sebagai **Penjawat Awam**, saya mahu memuat turun sijil kehadiran saya dalam masa 24 jam selepas acara tamat, supaya saya boleh memuatnaiknya ke fail LNPT saya.

**US-05:** Sebagai **Pengarah Jabatan**, saya mahu melihat laporan peratusan kehadiran kakitangan pada kursus wajib dalam suku tahun ini, supaya saya boleh mengambil tindakan terhadap kakitangan yang tidak hadir.

**US-06:** Sebagai **Pentadbir Sistem Negeri**, saya mahu mengeksport data kehadiran agregat semua jabatan kepada Excel mengikut kategori kursus, supaya saya boleh membuat laporan tahunan kepada SUK.

**US-07:** Sebagai **Penjawat Awam yang dijemput**, saya mahu memohon menggantikan kehadiran saya dengan rakan sejawat sekiranya saya tidak dapat hadir, supaya jabatan saya tetap diwakili dalam acara tersebut.

**US-08:** Sebagai **Penyelaras Latihan**, saya mahu menerima notifikasi kilat apabila terdapat permohonan gantian sama ada sebelum atau semasa acara, supaya saya boleh meluluskan dengan cepat tanpa melambatkan walk-in.

**US-09:** Sebagai **Wakil walk-in**, saya mahu boleh imbas QR di lokasi walaupun saya bukan dalam senarai jemputan asal, dan menyatakan siapa yang saya wakili, supaya kehadiran saya direkodkan secara sah selepas kelulusan Penyelaras.

**US-10:** Sebagai **Penjawat Awam yang menghadiri mesyuarat dalam talian**, saya mahu mendaftar kehadiran melalui pautan unik dalam e-mel jemputan saya, supaya saya tidak perlu imbas QR fizikal yang mustahil dilakukan dari rumah/pejabat saya.

**US-11:** Sebagai **Pengerusi mesyuarat dalam talian**, saya mahu memaparkan QR Code Dinamik pada skrin mesyuarat untuk peserta imbas, supaya saya pasti hanya peserta yang benar-benar join boleh daftar kehadiran.

**US-12:** Sebagai **Penyelaras kursus dalam talian 3 jam**, saya mahu sistem meminta peserta mengesahkan kehadiran mereka secara rawak 2-3 kali sepanjang sesi, supaya saya tahu mereka mengikuti kursus dan bukan hanya log masuk lalu meninggalkan komputer.

**US-13:** Sebagai **Penyelaras Latihan**, saya mahu mendaftarkan kursus 5 hari sebagai satu acara dengan 5 sesi (atau 10 sesi jika ada pagi/petang), supaya saya tidak perlu cipta 5 acara berasingan dan urus pendaftaran berulang.

**US-14:** Sebagai **Peserta kursus berbilang hari**, saya mahu melihat status kehadiran saya untuk setiap hari secara masa nyata, supaya saya tahu jika saya berisiko tidak layak menerima sijil.

**US-15:** Sebagai **Peserta yang dijemput ke kursus 5 hari**, saya mahu boleh memohon gantian untuk hari ke-3 sahaja (kerana saya ada mesyuarat YB), supaya saya boleh hadir hari 1, 2, 4, dan 5 secara peribadi dan wakil hanya menggantikan untuk hari ke-3.

**US-16:** Sebagai **Pengarah Jabatan**, saya mahu melihat berapa jam latihan yang telah dikumpul oleh setiap kakitangan saya pada tahun semasa, supaya saya boleh menggalakkan mereka mencapai sasaran 56 jam (7 hari) untuk LNPT.

**US-17:** Sebagai **Penjawat Awam**, saya mahu memuat turun penyata jam latihan tahunan saya dalam format yang boleh dilampirkan kepada borang LNPT, supaya proses penilaian prestasi saya lebih lancar.

**US-18:** Sebagai **Pentadbir Sistem Negeri (Super Admin)**, saya mahu mencipta peranan tersuai dengan kombinasi kebenaran khusus, supaya saya boleh menampung keperluan jabatan yang berbeza tanpa dipaksa menggunakan hanya peranan lalai.

**US-19:** Sebagai **Admin Jabatan**, saya hanya mahu melihat dan menguruskan pengguna serta acara di jabatan saya sahaja, supaya data jabatan lain dilindungi daripada akses yang tidak dibenarkan.

**US-20:** Sebagai **Penyelaras Latihan**, saya mahu mendelegasikan pengurusan acara saya kepada rakan sejawat semasa cuti panjang saya, dengan tarikh tamat automatik, supaya operasi tidak terganggu tetapi delegasi tidak kekal selamanya.

**US-21:** Sebagai **Pemangku Pengarah** semasa Pengarah saya bercuti, saya mahu peranan "Pemangku Ketua Jabatan" dilantik kepada saya dengan tarikh tamat automatik, supaya saya boleh meluluskan permohonan kursus tetapi peranan ini berakhir secara automatik apabila Pengarah kembali.

**US-22:** Sebagai **Penjawat Awam biasa**, saya mahu melihat senarai kebenaran yang saya ada dalam sistem, supaya saya tahu apa yang saya boleh dan tidak boleh lakukan tanpa cuba dan gagal.

**US-23:** Sebagai **Auditor Pejabat Audit Negeri**, saya memerlukan akses *read-only* kepada semua data merentas semua jabatan untuk tujuan pengauditan tahunan, tanpa keupayaan untuk mengubah suai apa-apa data.

---

## 8. User Flow Utama

### 8.1 Aliran Pendaftaran Acara oleh Jabatan

Penyelaras log masuk ke portal e-DAFTAR melalui pelayar web. Pada papan pemuka jabatannya, beliau klik butang "Daftar Acara Baharu". Borang dipaparkan meminta butiran berikut: tajuk acara, kategori (kursus/mesyuarat/bengkel/taklimat), penerangan, tarikh dan masa mula/tamat, lokasi (alamat fizikal atau pautan dalam talian), nama fasilitator/pengerusi, kuota peserta, dan senarai jemputan (boleh dimuat naik melalui CSV atau dipilih daripada direktori pengguna sistem).

Apabila penyelaras klik "Simpan & Jana QR", sistem mencipta rekod acara, menjana Kod QR unik yang dipautkan kepada ID acara, dan menghantar e-mel jemputan kepada semua peserta. Penyelaras boleh memuat turun Kod QR dalam format PDF atau PNG untuk dipaparkan pada banner, skrin, atau dicetak di kaunter pendaftaran.

### 8.2 Aliran Daftar Masuk oleh Peserta

Peserta tiba di lokasi acara. Mereka mengimbas Kod QR menggunakan kamera telefon (yang membuka pelayar) atau melalui aplikasi e-DAFTAR. Jika belum log masuk, mereka diminta log masuk dengan No. KP/No. Pekerja. Selepas pengesahan, sistem menyemak: (1) sama ada peserta dijemput ke acara ini, (2) sama ada masa imbasan dalam tempoh sah (mis. 30 minit sebelum mula hingga 30 minit selepas mula), dan (3) jika geolokasi diaktifkan, sama ada peserta berada dalam radius lokasi acara.

Jika semua syarat dipenuhi, sistem merekodkan kehadiran dan memaparkan skrin pengesahan dengan tanda hijau, butiran acara, dan masa daftar masuk. Peserta menerima e-mel pengesahan automatik. Jika gagal (mis. di luar radius, di luar tempoh masa), mesej ralat khusus dipaparkan dengan arahan susulan.

### 8.3 Aliran Penjanaan Sijil

Selepas acara tamat dan penyelaras menutup sesi, sistem menjana sijil PDF secara automatik untuk setiap peserta yang hadir, menggunakan templat rasmi jabatan. Sijil dipautkan dalam profil pengguna dan dihantar melalui e-mel.

### 8.4 Aliran Gantian Peserta — Dirancang Awal (Pra-Acara)

Peserta asal yang sedar tidak dapat hadir log masuk ke profil acara dalam sistem dan klik butang "Mohon Tukar Peserta". Beliau memilih wakil daripada direktori jabatan yang sama (atau memasukkan No. KP wakil), menyatakan alasan ringkas (mis. "Bertugas di mesyuarat YB"), dan menghantar permohonan. Sistem segera menghantar notifikasi kepada Penyelaras.

Penyelaras menyemak permohonan melalui papan pemuka atau notifikasi mudah alih, dan boleh meluluskan atau menolak dengan ulasan. Apabila diluluskan, sistem secara automatik (a) membatalkan jemputan peserta asal, (b) mengeluarkan jemputan baharu kepada wakil dengan butiran acara penuh, dan (c) mengemaskini senarai peserta. Audit log merekod transaksi penggantian dengan butiran lengkap.

### 8.5 Aliran Gantian Peserta — Walk-in (Semasa Acara)

Wakil tiba di kaunter pendaftaran tanpa pendaftaran awal dan mengimbas QR seperti biasa. Sistem mengesan No. KP wakil tiada dalam senarai jemputan dan memaparkan skrin alternatif: "Anda bukan dalam senarai peserta. Adakah anda mewakili sesiapa?"

Wakil pilih nama peserta asal daripada senarai peserta yang dijemput (atau masukkan No. KP), pilih alasan daripada senarai (cuti sakit, mesyuarat lain, tugasan rasmi, lain-lain), dan klik "Hantar Permohonan". Permohonan dihantar segera kepada Penyelaras melalui notifikasi push, SMS, atau e-mel keutamaan tinggi.

Penyelaras boleh meluluskan terus dari telefon dengan satu klik. Setelah diluluskan (sasaran tindak balas: dalam 5 minit), sistem mendaftarkan kehadiran wakil dengan tag khas "Wakil Gantian" dan menghantar pengesahan kepada wakil. Sekiranya tiada kelulusan, status kekal "Menunggu" dan tidak dikira sebagai kehadiran sah.

Untuk acara dengan **mod gantian terbuka** diaktifkan, langkah kelulusan dilangkau — wakil dari jabatan yang sama serta-merta didaftarkan, tetapi rekod tetap ditanda sebagai gantian untuk laporan.

### 8.6 Aliran Daftar Masuk untuk Acara Dalam Talian

Untuk acara berjenis dalam talian, mekanisme kehadiran berbeza daripada acara fizikal. Tidak terdapat lokasi fizikal, jadi geolokasi dinyahaktifkan secara automatik oleh sistem semasa konfigurasi acara. Tiga pendekatan disokong:

**Pautan Kehadiran Unik:** Setiap peserta menerima pautan unik dalam e-mel jemputan dengan format `daftar.kedah.gov.my/sesi/{kod-acara}?token={token-unik-peserta}`. Pada hari acara, peserta klik pautan, log masuk jika belum, dan kehadiran direkodkan serta-merta. Token hanya sah untuk peserta tersebut dan tidak boleh dikongsi kerana terikat dengan No. KP. Tempoh sah pautan boleh dikonfigur (mis. 30 minit sebelum hingga 1 jam selepas acara mula).

**QR pada Skrin Mesyuarat:** Pengerusi/fasilitator memaparkan QR Code (sebaiknya QR Dinamik) pada perkongsian skrin Zoom/Teams pada awal mesyuarat. Peserta yang join melihat QR tersebut dan imbas dengan telefon. Mekanisme ini mengesahkan peserta benar-benar join kerana hanya mereka yang dalam mesyuarat dapat melihat QR. QR Dinamik berputar 30 saat menghalang perkongsian gambar QR kepada rakan yang tidak join.

**Pengesahan Berterusan untuk Sesi Panjang:** Untuk sesi melebihi 90 minit, Penyelaras boleh aktifkan ciri ini. Sistem akan memaparkan butang pengesahan pada skrin peserta secara rawak 2–3 kali (mis. 45 minit, 90 minit, 135 minit ke dalam sesi). Peserta perlu klik dalam masa 3 minit. Kegagalan menjawab semua check-in mengakibatkan rekod kehadiran ditanda sebagai "Hadir Sebahagian" dengan peratusan kehadiran dikira (mis. 2/3 = 66%).

### 8.7 Aliran Daftar Masuk untuk Acara Hibrid

Untuk acara hibrid yang mempunyai peserta fizikal dan dalam talian serentak, kedua-dua mekanisme dijalankan selari. Peserta fizikal di lokasi imbas QR yang dipaparkan di kaunter dengan geolokasi aktif untuk pengesahan radius. Peserta dalam talian klik pautan unik mereka atau imbas QR yang dipaparkan oleh pengerusi pada perkongsian skrin (tanpa pengesahan geolokasi).

Penyelaras menetapkan jenis acara sebagai "Hibrid" dan menanda setiap peserta sebagai "Hadir Fizikal" atau "Hadir Dalam Talian" semasa jemputan. Pada masa daftar masuk, sistem menggunakan mekanisme yang bersesuaian untuk setiap kategori. Laporan akhir memaparkan pecahan kedua-dua jenis kehadiran.

### 8.8 Aliran Pendaftaran dan Kehadiran Acara Berbilang Hari

Penyelaras mendaftarkan acara dengan menanda pilihan "Acara Berbilang Hari" pada borang pendaftaran. Sistem kemudian membuka borang konfigurasi sesi yang membenarkan Penyelaras menambah sesi satu demi satu, atau menggunakan ciri "Auto-Jana Sesi" dengan memasukkan tarikh mula, tarikh tamat, dan corak harian (mis. "Setiap hari, 9:00 pagi – 5:00 petang dengan rehat 1:00 – 2:00 petang"). Untuk konfigurasi yang lebih kompleks, Penyelaras boleh memecahkan setiap hari kepada sesi pagi dan petang berasingan.

Setiap sesi mempunyai atribut tersendiri: tarikh, masa mula/tamat, jam latihan dikira (mis. 3.5 jam), status (wajib/opsyenal), dan QR Code unik. Penyelaras boleh memilih untuk mengaktifkan QR Dinamik secara seragam untuk semua sesi atau sesi terpilih sahaja. Pendaftaran peserta dilakukan sekali untuk seluruh acara — peserta tidak perlu mendaftar setiap hari.

Pada hari pertama, peserta menerima jemputan e-mel yang menyenaraikan jadual sesi penuh. Setiap pagi acara, sistem menghantar peringatan dengan QR yang sesuai untuk sesi hari tersebut. Peserta imbas QR setiap sesi mengikut prosedur biasa. Sistem mengumpul kehadiran setiap sesi secara berasingan.

Pada akhir acara, sistem mengira peratus kehadiran peserta berdasarkan formula: **(jam sesi wajib dihadiri ÷ jumlah jam sesi wajib) × 100%**. Sesi opsyenal tidak dikira dalam pengiraan minimum tetapi ditambah kepada jam latihan jika dihadiri. Jika peratus kehadiran mencapai ambang sijil yang dikonfigur (lalai 80%), sijil "Hadir Penuh" dijana. Jika di bawah ambang tetapi melebihi 50%, sijil "Hadir Sebahagian" dijana dengan butiran sesi yang dihadiri. Jika di bawah 50%, tiada sijil dikeluarkan.

### 8.9 Aliran Gantian Per Sesi (untuk Acara Berbilang Hari)

Peserta yang berdaftar untuk acara 5 hari menyedari beliau ada urusan rasmi pada hari ke-3 sahaja. Beliau log masuk ke profil acara, klik tab "Sesi", pilih sesi hari ke-3, dan klik "Mohon Gantian untuk Sesi Ini". Borang gantian dipaparkan dengan opsyen untuk memilih sesi tertentu (boleh pilih lebih daripada satu sesi yang berturutan jika perlu).

Beliau memilih wakil dari direktori jabatan yang sama, menyatakan alasan, dan menghantar permohonan. Setelah Penyelaras meluluskan, jadual berikut berlaku: peserta asal kekal sebagai peserta sah untuk hari 1, 2, 4, 5; wakil didaftarkan sebagai peserta tambahan untuk hari 3 sahaja. Pada hari 1, 2, 4, dan 5, hanya peserta asal boleh imbas QR. Pada hari 3, hanya wakil boleh imbas QR.

Pengiraan kehadiran akhir dilakukan secara berasingan: peserta asal dinilai berdasarkan kehadiran beliau (4/5 hari = 80%, mungkin layak sijil); wakil dinilai berdasarkan satu hari (100% untuk hari yang ditugaskan, tetapi tidak layak sijil penuh kerana beliau hanya berdaftar untuk 1 sesi sahaja). Sijil "Wakil Hadir Sesi" yang berasingan dikeluarkan untuk wakil dengan butiran sesi yang dihadiri sahaja.

### 8.10 Aliran Penjejakan Jam Latihan untuk LNPT

Setiap kali peserta hadir sesi (sama ada acara satu hari atau acara berbilang hari), sistem secara automatik menambah jam latihan kepada baki kumulatif tahunan pengguna. Jam dikira berdasarkan tempoh sesi sebenar (mis. sesi 9:00 – 12:00 = 3 jam) dan dikategorikan sebagai "Kursus Wajib", "Kursus Sukarela", "Mesyuarat", "Bengkel", atau "Seminar".

Peserta boleh melihat papan pemuka peribadi yang memaparkan: jumlah jam latihan tahun semasa, sasaran 56 jam (atau ambang yang ditetapkan jabatan), pecahan mengikut kategori, dan senarai semua acara yang dihadiri dengan jam dikira. Beliau juga boleh memuat turun "Penyata Jam Latihan Tahunan" dalam format PDF atau Excel yang seragam dengan keperluan LNPT, lengkap dengan tandatangan digital sistem untuk pengesahan.

Pengarah Jabatan dan Pegawai Penilai dapat melihat status pengumpulan jam latihan setiap kakitangan melalui papan pemuka pengurusan, dengan penanda visual untuk kakitangan yang berisiko tidak mencapai sasaran. Notifikasi automatik boleh dihantar pada Q3 setiap tahun kepada kakitangan yang masih kurang daripada 50% sasaran.

### 8.11 Aliran Pelantikan Peranan dan Delegasi

**Pelantikan Peranan Standard:** Super Admin atau Admin Jabatan log masuk ke modul "Pengurusan Pengguna", memilih pengguna sasaran, dan klik "Tambah Peranan". Sistem memaparkan senarai peranan yang boleh dilantik mengikut kebenaran pelantik (Admin Jabatan hanya boleh melantik peranan yang lebih rendah dari peranan beliau). Pelantik memilih peranan, menetapkan skop (jabatan tertentu atau semua jabatan jika dibenarkan), dan menetapkan tarikh tamat (opsyenal — kosong bermaksud tiada tamat). Setelah disimpan, sistem menghantar notifikasi e-mel kepada pengguna yang dilantik dan merekodkan transaksi dalam audit log.

**Delegasi Sementara:** Penyelaras yang akan bercuti panjang log masuk ke profil sendiri, klik tab "Delegasi", dan klik "Cipta Delegasi Baharu". Beliau memilih rakan sejawat sebagai penerima delegasi, memilih peranan/kebenaran yang akan didelegasikan (boleh sebahagian atau semua), menetapkan tarikh mula dan tarikh tamat, dan menyatakan alasan. Permohonan dihantar kepada Admin Jabatan untuk kelulusan. Setelah diluluskan, penerima delegasi mendapat akses kepada peranan tersebut dalam tempoh yang ditetapkan, dan sistem secara automatik mencabut akses pada tarikh tamat tanpa intervensi manual.

**Pelantikan Pemangku (Acting Role):** Apabila Pengarah Jabatan mengambil cuti panjang, Super Admin atau Setiausaha Bahagian boleh melantik Pemangku menggunakan ciri "Pelantikan Pemangku". Borang ini meminta: pengguna pemangku, peranan asal yang dipangkukan, tarikh mula, tarikh tamat (atau "Sehingga arahan baru"), dan rujukan surat pelantikan rasmi. Pemangku menerima notifikasi dan dapat menjalankan tanggungjawab penuh peranan tersebut dalam tempoh dilantik. Sistem menanda semua tindakan pemangku dengan label "[Pemangku]" dalam audit log untuk ketelusan.

**Self-Service Lihat Kebenaran:** Mana-mana pengguna boleh log masuk dan klik "Profil Saya" → "Kebenaran Saya". Sistem memaparkan senarai semua peranan aktif beliau, kebenaran yang dilekatkan pada setiap peranan, skop (jabatan), tarikh tamat (jika ada), dan delegasi aktif (sama ada beliau penerima atau pemberi). Maklumat ini bertujuan ketelusan — pengguna sentiasa tahu apa yang mereka boleh akses tanpa mencuba dan gagal.

---

## 9. Keperluan Fungsian (Functional Requirements)

### 9.1 Modul Pengurusan Pengguna

| ID | Keperluan |
|----|-----------|
| FR-1.1 | Sistem mesti membenarkan pendaftaran pengguna dengan No. KP (12 digit) sebagai pengecam unik |
| FR-1.2 | Profil pengguna mesti merangkumi: nama penuh, No. KP, No. Pekerja, e-mel rasmi, no. telefon, jabatan, jawatan, gred, PTJ |
| FR-1.3 | Sistem mesti menyokong peranan berhierarki dengan kebenaran granular (rujuk Modul 9.11 RBAC untuk butiran lengkap) |
| FR-1.4 | Pengguna boleh mengemas kini profil sendiri kecuali medan kritikal (No. KP, jabatan) yang memerlukan pengesahan Admin |
| FR-1.5 | Sistem mesti menyokong import pukal pengguna melalui CSV mengikut format standard MAMPU |

### 9.2 Modul Pendaftaran Acara

| ID | Keperluan |
|----|-----------|
| FR-2.1 | Sistem mesti membenarkan Penyelaras mendaftarkan acara dengan minimum: tajuk, kategori, tarikh/masa, lokasi |
| FR-2.2 | Setiap acara mesti mempunyai pengecam unik (UUID) dan rujukan no. acara mesra pengguna (mis. KEDAH-2026-LATIH-0142) |
| FR-2.3 | Penyelaras boleh menambah peserta secara individu, mengikut jabatan, mengikut gred, atau melalui muat naik CSV |
| FR-2.4 | Sistem mesti menyokong acara berulang (siri kursus 3 hari, mesyuarat bulanan) |
| FR-2.5 | Acara boleh dipinda atau dibatalkan, dengan notifikasi automatik kepada semua peserta |

### 9.3 Modul Penjanaan & Imbasan QR

| ID | Keperluan |
|----|-----------|
| FR-3.1 | QR Code mesti mengandungi URL ringkas yang menghala ke laman daftar masuk acara dengan token bertandatangan (JWT) |
| FR-3.2 | Token QR mesti mengandungi ID acara, masa tamat tempoh, dan tandatangan digital untuk mencegah pemalsuan |
| FR-3.3 | Penyelaras boleh memilih mod **QR Statik** (kekal sepanjang acara) atau **QR Dinamik** (berputar setiap 30 saat) |
| FR-3.4 | Imbasan QR mesti berfungsi pada kamera asli iOS/Android tanpa memerlukan aplikasi tertentu |
| FR-3.5 | Sistem mesti merekodkan: ID peserta, ID acara, cap masa imbasan, koordinat geolokasi (jika dibenarkan), alat imbasan |

### 9.4 Modul Notifikasi

| ID | Keperluan |
|----|-----------|
| FR-4.1 | E-mel jemputan mesti dihantar dalam masa 5 minit selepas acara didaftarkan |
| FR-4.2 | Peringatan automatik H-7 hari, H-1 hari, dan H-1 jam |
| FR-4.3 | Notifikasi push (jika menggunakan apl mudah alih) |
| FR-4.4 | Sokongan templat e-mel boleh disesuaikan oleh setiap jabatan |

### 9.5 Modul Laporan

| ID | Keperluan |
|----|-----------|
| FR-5.1 | Papan pemuka masa nyata menunjukkan: jumlah peserta hadir vs jangkaan, peratusan kehadiran |
| FR-5.2 | Laporan eksport ke PDF, Excel (XLSX), dan CSV |
| FR-5.3 | Penapis: julat tarikh, jabatan, kategori acara, gred peserta, status kehadiran |
| FR-5.4 | Laporan agregat tahunan untuk SUK Kedah merangkumi semua jabatan |

### 9.6 Modul Sijil

| ID | Keperluan |
|----|-----------|
| FR-6.1 | Sijil dijana automatik untuk peserta yang hadir sekurang-kurangnya 80% tempoh acara (jika check-out diaktifkan) |
| FR-6.2 | Sijil mesti mempunyai QR pengesahan untuk semakan keaslian oleh pihak ketiga |
| FR-6.3 | Templat sijil boleh disesuaikan dengan logo jabatan dan tandatangan Ketua Jabatan |

### 9.7 Modul Pengurusan Gantian

| ID | Keperluan |
|----|-----------|
| FR-7.1 | Peserta asal mesti boleh memohon gantian sebelum acara melalui antara muka profil acara |
| FR-7.2 | Sistem mesti menyokong tiga mod gantian: dirancang awal, walk-in dengan kelulusan, dan terbuka (auto-lulus) |
| FR-7.3 | Permohonan gantian mesti merangkumi: peserta asal, wakil, alasan, masa permohonan, status |
| FR-7.4 | Penyelaras mesti boleh meluluskan/menolak permohonan dari papan pemuka web atau notifikasi mudah alih |
| FR-7.5 | Sasaran tindak balas kelulusan walk-in: 5 minit dari masa permohonan dihantar |
| FR-7.6 | Wakil mesti dari jabatan yang sama dengan peserta asal (tetapan boleh dilonggarkan oleh Super Admin) |
| FR-7.7 | Rekod kehadiran wakil mesti ditanda secara jelas sebagai "Wakil Gantian" dalam laporan dan sijil |
| FR-7.8 | Sijil dikeluarkan atas nama wakil yang sebenar hadir, BUKAN peserta asal |
| FR-7.9 | Audit log mesti merekodkan: ID peserta asal, ID wakil, alasan, ID Penyelaras yang lulus, cap masa setiap peringkat |
| FR-7.10 | Notifikasi automatik dihantar kepada peserta asal apabila gantian beliau diluluskan, supaya beliau sedar telah digantikan |
| FR-7.11 | Laporan agregat mesti boleh memaparkan kadar gantian per acara dan per jabatan untuk analisis trend |
| FR-7.12 | Sistem mesti menghalang gantian berantai (wakil tidak boleh diganti oleh wakil lain dalam acara yang sama) |

### 9.8 Modul Acara Dalam Talian dan Hibrid

| ID | Keperluan |
|----|-----------|
| FR-8.1 | Penyelaras mesti boleh menanda jenis acara sebagai: Fizikal, Dalam Talian, atau Hibrid semasa pendaftaran |
| FR-8.2 | Pengesahan geolokasi mesti dinyahaktifkan secara automatik untuk acara berjenis Dalam Talian |
| FR-8.3 | Sistem mesti menjana pautan kehadiran unik per peserta untuk acara Dalam Talian, terikat dengan No. KP |
| FR-8.4 | Pautan unik mesti mempunyai tempoh sah yang boleh dikonfigur (lalai: 30 minit sebelum hingga 60 minit selepas masa mula) |
| FR-8.5 | Pautan unik tidak boleh dikongsi — percubaan akses dari sesi log masuk berbeza akan ditolak |
| FR-8.6 | QR Code pada skrin mesyuarat mesti menyokong mod Dinamik (berputar 30s) untuk mencegah perkongsian gambar |
| FR-8.7 | Penyelaras mesti boleh aktifkan ciri Pengesahan Berterusan untuk sesi melebihi 90 minit |
| FR-8.8 | Sistem mesti memaparkan butang pengesahan pada masa rawak (algoritma: 2-3 kali pada selang minimum 30 minit) |
| FR-8.9 | Tempoh tindak balas pengesahan berterusan mesti boleh dikonfigur (lalai: 3 minit) |
| FR-8.10 | Peserta yang gagal sebahagian pengesahan mesti ditanda "Hadir Sebahagian" dengan peratusan dikira |
| FR-8.11 | Penjanaan sijil untuk Hadir Sebahagian mesti mengikut ambang yang ditetapkan Penyelaras (lalai: minimum 75% pengesahan) |
| FR-8.12 | Untuk acara Hibrid, sistem mesti menyokong dua mekanisme kehadiran serentak (QR fizikal + pautan dalam talian) |
| FR-8.13 | Setiap peserta acara Hibrid mesti dikategorikan "Hadir Fizikal" atau "Hadir Dalam Talian" semasa jemputan |
| FR-8.14 | Laporan acara Hibrid mesti memaparkan pecahan kehadiran fizikal vs dalam talian secara berasingan |
| FR-8.15 | Pada fasa kemudian, sistem mesti menyokong integrasi API dengan Zoom, Google Meet, dan Microsoft Teams untuk pengesahan kehadiran automatik |

### 9.9 Modul Acara Berbilang Hari dan Sesi

| ID | Keperluan |
|----|-----------|
| FR-9.1 | Sistem mesti menyokong struktur acara induk dengan mana-mana bilangan sesi (minimum 1, maksimum 50) |
| FR-9.2 | Setiap sesi mesti mempunyai atribut sendiri: tarikh, masa mula, masa tamat, lokasi (jika berbeza), QR Code, dan jam latihan dikira |
| FR-9.3 | Penyelaras mesti boleh menanda setiap sesi sebagai "Wajib" atau "Opsyenal" |
| FR-9.4 | Sistem mesti menyediakan ciri "Auto-Jana Sesi" berdasarkan tarikh mula, tarikh tamat, dan corak harian |
| FR-9.5 | Pendaftaran peserta mesti sekali untuk seluruh acara, bukan setiap sesi |
| FR-9.6 | Setiap sesi mesti mempunyai QR Code unik yang berasingan untuk mencegah peserta imbas QR sesi berlainan secara salah |
| FR-9.7 | Tempoh sah imbas QR mesti dikonfigur per sesi (lalai: 30 minit sebelum mula hingga 30 minit selepas mula) |
| FR-9.8 | Sistem mesti mengira peratus kehadiran sebagai (jam sesi wajib dihadiri ÷ jumlah jam sesi wajib) × 100% |
| FR-9.9 | Sesi opsyenal yang dihadiri mesti ditambah kepada jumlah jam latihan, tetapi tidak mempengaruhi pengiraan ambang minimum |
| FR-9.10 | Ambang sijil mesti boleh dikonfigur per acara (lalai 80%, julat 50–100%) |
| FR-9.11 | Sistem mesti menyokong tiga jenis sijil: Hadir Penuh (≥ ambang), Hadir Sebahagian (50% – ambang), dan Tiada Sijil (< 50%) |
| FR-9.12 | Peserta mesti boleh melihat status kehadiran setiap sesi secara masa nyata sepanjang acara |
| FR-9.13 | Penyelaras mesti boleh memodifikasi sesi (tambah, padam, anjak masa) sebelum sesi tersebut bermula, dengan notifikasi automatik kepada peserta |
| FR-9.14 | Sistem mesti membenarkan gantian per sesi: peserta hadir sebahagian sesi, wakil ganti baki sesi |
| FR-9.15 | Untuk gantian per sesi, sistem mesti menjana sijil berasingan untuk peserta asal dan wakil mengikut sesi yang dihadiri masing-masing |
| FR-9.16 | Sistem mesti menyokong acara siri (recurring) di mana setiap "kejadian" dianggap acara berasingan dengan pendaftaran berasingan |
| FR-9.17 | Untuk acara siri, sistem mesti menyediakan templat yang boleh diguna semula untuk mengelakkan pengisian berulang |
| FR-9.18 | Pembatalan acara separuh jalan (mis. selepas hari 2 daripada 5) mesti memicu logik pengiraan: peserta yang telah hadir sesi sebelum pembatalan mendapat sijil pro-rata |

### 9.10 Modul Penjejakan Jam Latihan untuk LNPT

| ID | Keperluan |
|----|-----------|
| FR-10.1 | Sistem mesti mengira jam latihan kumulatif tahunan untuk setiap pengguna secara automatik |
| FR-10.2 | Jam latihan dikira berdasarkan tempoh sesi sebenar dihadiri, dibundarkan kepada perpuluhan terdekat (mis. 3.5 jam) |
| FR-10.3 | Setiap acara mesti dikategorikan untuk pengiraan: Kursus Wajib, Kursus Sukarela, Mesyuarat, Bengkel, Seminar, Latihan Khusus |
| FR-10.4 | Pengguna mesti boleh melihat papan pemuka peribadi: jumlah jam, sasaran, pecahan kategori, senarai acara dihadiri |
| FR-10.5 | Sasaran lalai jam latihan ialah 56 jam setahun, tetapi boleh dikonfigur per jabatan atau gred |
| FR-10.6 | Sistem mesti menyediakan eksport "Penyata Jam Latihan Tahunan" dalam format PDF dan Excel |
| FR-10.7 | Penyata mesti mengandungi tandatangan digital sistem dengan QR pengesahan untuk semakan keaslian oleh penilai LNPT |
| FR-10.8 | Pengarah dan Pegawai Penilai mesti boleh melihat status jam latihan kakitangan di bawah seliaan mereka |
| FR-10.9 | Sistem mesti menghantar notifikasi automatik kepada kakitangan yang berisiko tidak mencapai sasaran (di bawah 50% pada Q3, di bawah 75% pada Q4) |
| FR-10.10 | Laporan agregat peringkat jabatan: peratus kakitangan yang mencapai sasaran, purata jam latihan, kategori paling popular |
| FR-10.11 | Pengiraan jam latihan mesti diasingkan jelas mengikut tahun kalendar (1 Jan – 31 Dis), dengan rekod sejarah dikekalkan tanpa had masa |
| FR-10.12 | Untuk gantian, jam latihan dikreditkan kepada wakil yang sebenar hadir, BUKAN peserta asal |

### 9.11 Modul RBAC dan Pengurusan Akses

Modul ini menentukan rangka kerja kawalan akses berasaskan peranan untuk seluruh sistem. Pendekatan yang dipilih adalah **Role-Based Access Control (RBAC) dengan skop jabatan dan kebenaran granular** — gabungan keselamatan dan fleksibiliti yang sesuai untuk struktur kerajaan negeri.

#### 9.11.1 Peranan Lalai Sistem

Sistem menyediakan sembilan peranan lalai yang merangkumi keperluan operasi standard. Peranan disusun mengikut hierarki, di mana peranan lebih tinggi mempunyai semua kebenaran peranan lebih rendah ditambah kebenaran khusus.

| Kod Peranan | Nama Peranan | Skop | Penerangan |
|-------------|--------------|------|------------|
| `super_admin` | Super Admin Negeri | Seluruh negeri | Akses penuh sistem; konfigurasi, peranan tersuai, audit |
| `admin_negeri` | Pegawai Pentadbir Negeri | Seluruh negeri | Pengurusan operasi merentas jabatan; tiada konfigurasi sistem |
| `admin_jabatan` | Pentadbir Jabatan | Satu jabatan | Pengurusan pengguna, peranan, tetapan jabatan |
| `penyelaras` | Penyelaras Latihan | Satu jabatan | Pendaftaran acara, jemputan, sijil, laporan jabatan |
| `pengerusi_acara` | Pengerusi Acara | Acara tertentu | Pengurusan satu acara spesifik (resource-level) |
| `ketua_jabatan` | Ketua Jabatan / Pengarah | Satu jabatan | Lihat laporan jabatan, status jam latihan kakitangan |
| `pegawai_penilai` | Pegawai Penilai | Pasukan tertentu | Lihat jam latihan kakitangan di bawah seliaan untuk LNPT |
| `auditor` | Auditor Negeri | Seluruh negeri (read-only) | Akses baca-sahaja semua data untuk pengauditan |
| `peserta` | Peserta / Penjawat Awam | Sendiri sahaja | Lihat acara dijemput, imbas QR, lihat sijil/jam sendiri |

#### 9.11.2 Kategori dan Senarai Kebenaran

Kebenaran (permissions) disusun mengikut kategori modul, dengan format `<modul>.<tindakan>` (mis. `event.create`, `user.delete`).

**Kebenaran Pengguna (`user.*`):** view_own, view_jabatan, view_all, create, update_own, update_jabatan, update_all, delete, import_csv, export.

**Kebenaran Acara (`event.*`):** view_own, view_jabatan, view_all, create, update_own, update_jabatan, update_all, cancel, duplicate, generate_qr.

**Kebenaran Sesi (`session.*`):** view, create, update, delete, regenerate_qr.

**Kebenaran Kehadiran (`attendance.*`):** view_own, view_jabatan, view_all, mark_manual, override, export.

**Kebenaran Gantian (`substitution.*`):** request_own, approve_jabatan, approve_all, view_history.

**Kebenaran Sijil (`certificate.*`):** view_own, view_jabatan, view_all, generate, regenerate, revoke.

**Kebenaran Laporan (`report.*`):** view_jabatan, view_state, generate_custom, export.

**Kebenaran Jam Latihan (`training_hours.*`):** view_own, view_team, view_jabatan, view_state, export_lnpt.

**Kebenaran RBAC (`rbac.*`):** view_roles, create_role, update_role, delete_role, assign_role_jabatan, assign_role_all, delegate, approve_delegation, manage_acting_role.

**Kebenaran Sistem (`system.*`):** view_audit_log, configure_settings, manage_departments, manage_templates, manage_notifications.

#### 9.11.3 Matriks Peranan vs Kebenaran (Subset Utama)

Matriks ini menunjukkan kebenaran utama bagi setiap peranan lalai. Tanda **✓** bermaksud kebenaran diberikan, **✓\*** bermaksud terhad pada skop tertentu (jabatan/sendiri), dan **—** bermaksud tiada akses.

| Kebenaran | Super Admin | Admin Negeri | Admin Jabatan | Penyelaras | Ketua Jab. | Peg. Penilai | Auditor | Peserta |
|-----------|:-----------:|:------------:|:-------------:|:----------:|:----------:|:------------:|:-------:|:-------:|
| user.view_all | ✓ | ✓ | ✓\* | — | ✓\* | — | ✓ | — |
| user.create | ✓ | ✓ | ✓\* | — | — | — | — | — |
| user.delete | ✓ | — | — | — | — | — | — | — |
| event.create | ✓ | ✓ | ✓\* | ✓\* | — | — | — | — |
| event.cancel | ✓ | ✓ | ✓\* | ✓\* (own) | — | — | — | — |
| attendance.override | ✓ | ✓ | ✓\* | ✓\* (own event) | — | — | — | — |
| substitution.approve | ✓ | ✓ | ✓\* | ✓\* (own event) | — | — | — | — |
| certificate.regenerate | ✓ | ✓ | ✓\* | ✓\* (own event) | — | — | — | — |
| report.view_state | ✓ | ✓ | — | — | — | — | ✓ | — |
| report.view_jabatan | ✓ | ✓ | ✓\* | ✓\* | ✓\* | — | ✓\* | — |
| training_hours.view_team | ✓ | ✓ | ✓\* | — | ✓\* | ✓\* | ✓\* | — |
| rbac.create_role | ✓ | — | — | — | — | — | — | — |
| rbac.assign_role_jabatan | ✓ | ✓ | ✓\* | — | — | — | — | — |
| rbac.delegate | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | — | — |
| system.view_audit_log | ✓ | ✓ | ✓\* | — | — | — | ✓ | — |
| system.configure_settings | ✓ | — | — | — | — | — | — | — |

**Contoh interpretasi:** Penyelaras boleh meluluskan permohonan gantian (`substitution.approve`), tetapi hanya untuk acara yang beliau dicipta sendiri (skop "own event"). Penyelaras tidak boleh meluluskan gantian untuk acara Penyelaras lain, walaupun dalam jabatan yang sama — kecuali jika beliau juga memegang peranan Admin Jabatan.

#### 9.11.4 Keperluan Fungsian RBAC

| ID | Keperluan |
|----|-----------|
| FR-11.1 | Sistem mesti menyediakan 9 peranan lalai seperti yang disenaraikan dalam Seksyen 9.11.1 |
| FR-11.2 | Setiap peranan mesti mempunyai kebenaran granular yang dilampirkan, boleh dilihat dalam antara muka pengurusan |
| FR-11.3 | Super Admin mesti boleh mencipta peranan tersuai dengan kombinasi kebenaran sedia ada |
| FR-11.4 | Sistem mesti menghalang penghapusan peranan lalai sistem (`adalah_lalai_sistem = true`) |
| FR-11.5 | Pengguna boleh memegang lebih daripada satu peranan serentak; kebenaran adalah penyatuan (UNION) semua peranan aktif |
| FR-11.6 | Pelantikan peranan mesti boleh diberi skop kepada satu jabatan tertentu, beberapa jabatan, atau seluruh negeri |
| FR-11.7 | Pelantikan peranan mesti menyokong tarikh mula dan tarikh tamat opsyenal; sistem secara automatik mencabut akses pada tarikh tamat |
| FR-11.8 | Penyelaras yang dicipta sebagai "pemilik" sesuatu acara mesti diberi kebenaran resource-level pada acara tersebut sahaja, walaupun mereka tiada peranan global "Penyelaras" |
| FR-11.9 | Sistem mesti menyokong delegasi sementara: pengguna A mendelegasikan peranan/kebenaran kepada pengguna B dengan tempoh tarikh tertentu |
| FR-11.10 | Delegasi mesti dilulus oleh Admin Jabatan sebelum berkuat kuasa, kecuali delegasi peranan rendah (mis. Penyelaras → Penyelaras lain) yang boleh diluluskan oleh peranan yang sama |
| FR-11.11 | Sistem mesti menyokong "Pemangku Jawatan" (acting role) dengan rujukan surat pelantikan rasmi, tarikh tamat, dan tag `[Pemangku]` pada audit log |
| FR-11.12 | Setiap perubahan peranan/kebenaran mesti direkodkan dalam audit log dengan: pelaku, sasaran, peranan/kebenaran terlibat, masa, alasan (jika diberikan) |
| FR-11.13 | Sistem mesti menyediakan antara muka self-service "Kebenaran Saya" untuk setiap pengguna |
| FR-11.14 | Sistem mesti menghantar notifikasi e-mel kepada pengguna apabila peranan baharu dilantik atau dicabut |
| FR-11.15 | Pengguna dengan peranan dicabut mesti hilang akses dalam masa 60 saat (pemberhentian sesi aktif) |
| FR-11.16 | Penegakan kebenaran mesti dilakukan pada lapisan API/middleware, BUKAN hanya pada antara muka — tiada bypass melalui panggilan API langsung |
| FR-11.17 | Sistem mesti menyokong "deny-by-default" — pengguna tanpa kebenaran khusus tidak boleh mengakses sumber/tindakan tersebut |
| FR-11.18 | Pengguna `auditor` mesti mempunyai akses baca penuh tetapi DILARANG sepenuhnya daripada sebarang tindakan tulis (create/update/delete) walaupun secara API |
| FR-11.19 | Sistem mesti menyediakan laporan "Pengguna mengikut Peranan" untuk Admin: senarai siapa yang memegang peranan apa, dengan tarikh tamat |
| FR-11.20 | Sistem mesti menyediakan laporan "Kebenaran Sensitif" yang menyenaraikan semua pengguna dengan kebenaran kritikal (mis. `user.delete`, `system.configure_settings`) untuk semakan keselamatan berkala |

#### 9.11.5 Pertimbangan Khusus

**Skop dan Multi-Tenancy:** Setiap kebenaran yang sensitif terhadap data jabatan (mis. `event.update`, `report.view_jabatan`) mesti dilengkapi dengan skop. Sebagai contoh, Admin Jabatan A tidak sepatutnya dapat melihat acara di Jabatan B walaupun beliau mempunyai kebenaran `event.view_jabatan` — kerana skop beliau terhad pada Jabatan A. Ini dikuatkuasakan pada peringkat pertanyaan pangkalan data (query scope) dan bukan hanya UI.

**Resource-Level Permissions:** Untuk acara, terdapat dua lapisan kebenaran. Lapisan pertama ialah peranan global (Penyelaras boleh `event.create` dalam jabatan beliau). Lapisan kedua ialah pemilikan resource — Penyelaras yang mencipta acara X menjadi "pemilik" acara X dan mendapat kebenaran penuh ke atasnya, walaupun Penyelaras lain dalam jabatan yang sama mungkin tidak. Ini menyokong senario di mana acara sensitif (mis. taklimat untuk pegawai kanan) hanya boleh diuruskan oleh Penyelaras tertentu.

**Konflik Peranan:** Apabila pengguna memegang peranan dengan kebenaran bercanggah (mis. `peserta` membenarkan `event.view_own` tetapi `admin_jabatan` membenarkan `event.view_jabatan`), sistem menggunakan prinsip "most permissive wins" — kebenaran yang lebih luas berkuat kuasa. Tetapi untuk skop, sistem mengambil intersection: jika pengguna adalah Admin Jabatan A dan Penyelaras Jabatan B, beliau hanya boleh menguruskan acara Jabatan A (Admin) dan Jabatan B (Penyelaras), bukan jabatan lain.

**Akaun Tanpa Peranan:** Pengguna yang baharu didaftarkan tanpa peranan eksplisit secara automatik diberikan peranan `peserta` sebagai lalai. Tiada pengguna boleh wujud dalam sistem tanpa sekurang-kurangnya satu peranan.

**Pencabutan Akses Segera:** Apabila peranan kritikal dicabut (mis. Admin Jabatan dipindahkan), sistem mesti membatalkan token sesi aktif pengguna tersebut dalam masa 60 saat melalui mekanisme pengesahan token pada setiap permintaan API. Ini penting untuk keselamatan apabila pegawai dipindahkan secara tiba-tiba atau diberhentikan.

**Implementasi dengan Spatie Laravel Permission:** Pakej ini menyediakan asas RBAC yang teguh dengan sokongan untuk peranan, kebenaran, dan model-binding. Untuk skop jabatan, kami akan melanjutkan pakej dengan global query scopes pada model Eloquent supaya pertanyaan pangkalan data secara automatik ditapis mengikut skop pengguna semasa. Untuk resource-level permissions, kami akan menggunakan **Laravel Policies** yang menyemak pemilikan acara di samping peranan global.

---

## 10. Keperluan Bukan Fungsian (Non-Functional Requirements)

**Prestasi:** Halaman utama mesti dimuat dalam 2 saat pada sambungan 4G. Operasi imbas QR (dari imbas hingga pengesahan) mesti diselesaikan dalam 3 saat.

**Skalabiliti:** Sistem mesti menyokong sehingga 50,000 pengguna aktif dan 500 acara serentak tanpa kemerosotan prestasi.

**Ketersediaan:** SLA 99.5% (kira-kira 3.6 jam henti dibenarkan sebulan), tidak termasuk tetingkap penyelenggaraan terjadual yang dimaklumkan 48 jam awal.

**Keselamatan:** Mematuhi MyMIS (Malaysian Public Sector Management of ICT Security), penyulitan TLS 1.3 untuk pengangkutan data, AES-256 untuk data tidak aktif, dan ujian penembusan tahunan.

**Privasi:** Mematuhi Akta Perlindungan Data Peribadi 2010 (PDPA). Data peserta hanya boleh diakses oleh pentadbir jabatan masing-masing dan Super Admin negeri. Persetujuan jelas untuk pemprosesan data biometrik (jika geolokasi dianggap demikian).

**Kebolehgunaan:** Antara muka mesti boleh digunakan tanpa latihan untuk operasi asas (log masuk, imbas QR). Latihan 1 jam mencukupi untuk Penyelaras menguasai semua fungsi.

**Keserasian:** Disokong pada pelayar Chrome, Edge, Safari, Firefox versi semasa. Apl mudah alih menyokong Android 9.0+ dan iOS 14+.

**Aksesibiliti:** Mematuhi standard WCAG 2.1 Tahap AA, termasuk sokongan pembaca skrin dan kontras warna mencukupi untuk pengguna OKU.

**Penyetempatan:** Antara muka penuh dalam Bahasa Malaysia sebagai lalai, dengan pilihan Bahasa Inggeris.

---

## 11. Seni Bina Teknikal (Cadangan)

### 11.1 Stack Teknologi Disyorkan: Laravel + MySQL

**Cadangan utama:** Sistem ini akan dibangunkan menggunakan **Laravel 11 (PHP 8.2+)** sebagai rangka kerja belakang dan **MySQL 8.0+** (atau MariaDB 10.6+) sebagai pangkalan data utama. Pilihan ini didorong oleh konteks khusus pembangunan sistem dalam sektor awam Malaysia.

**Justifikasi pemilihan Laravel:**

Pertama, ekosistem pembangun PHP/Laravel sangat luas di Malaysia, terutamanya dalam kalangan vendor ICT yang berkhidmat dengan kerajaan negeri dan persekutuan. Ini mengurangkan risiko kebergantungan pada pakar luar dan memudahkan peralihan vendor sekiranya berlaku perubahan kontrak. Kedua, Laravel menyediakan kepantasan pembangunan yang signifikan melalui konvensyen "convention over configuration", ORM Eloquent yang mantap, dan sistem migrasi pangkalan data yang teratur. Ketiga, Laravel mempunyai perlindungan keselamatan terbina dalam (CSRF, XSS, SQL injection, mass assignment) yang selari dengan keperluan MyMIS dan polisi keselamatan ICT MAMPU. Keempat, kos hosting aplikasi PHP adalah lebih rendah berbanding stack lain dan boleh dijalankan pada infrastruktur pelayan dalaman SUK Kedah tanpa perlu persekitaran kontena yang kompleks.

**Justifikasi pemilihan MySQL:**

MySQL 8.0+ adalah pangkalan data relational yang matang, telah terbukti dalam jutaan aplikasi pengeluaran, dan menyokong semua keperluan sistem ini termasuk window functions, JSON columns, transaksi ACID, dan extension spatial untuk pengesahan radius geolokasi. Bagi konteks volume data sistem (50,000 pengguna aktif, 500+ acara serentak, jutaan rekod kehadiran tahunan), MySQL beroperasi dengan selesa tanpa perlu pengoptimuman ekstrim. Tambahan pula, MySQL ialah pangkalan data standard yang digunakan pada sistem-sistem kerajaan negeri Kedah sedia ada, memudahkan integrasi dan operasi penyelenggaraan oleh pasukan BPM Negeri.

### 11.2 Penilaian Kesesuaian: Adakah Laravel + MySQL Sesuai?

Untuk menjawab persoalan secara langsung dan jujur, berikut ialah penilaian setiap keperluan kritikal sistem terhadap keupayaan Laravel + MySQL:

| Keperluan Sistem | Kesesuaian Laravel + MySQL | Catatan |
|-------------------|------------------------------|---------|
| Penjanaan & imbasan QR Code | ✅ Sangat sesuai | Pakej `simplesoftwareio/simple-qrcode` matang, pemprosesan token JWT pantas |
| Pengesahan pengguna (No. KP, 2FA) | ✅ Sangat sesuai | Laravel Sanctum + Breeze, sokongan OTP melalui pakej tambahan |
| Pengiriman e-mel pukal jemputan | ✅ Sangat sesuai | Laravel Queue + Redis, mampu hantar 10,000+ e-mel/jam |
| Penjanaan sijil PDF | ✅ Sangat sesuai | DomPDF (mudah) atau Browsershot (kompleks) |
| Papan pemuka kehadiran masa nyata | ✅ Sesuai dengan Laravel Reverb | WebSocket asli sejak Laravel 11 (2024) |
| Pengesahan radius geolokasi | ✅ Mencukupi | MySQL 8 mempunyai `ST_Distance_Sphere` — cukup untuk semakan radius asas (<10km) |
| Pengiraan jam latihan kumulatif | ✅ Sangat sesuai | Window functions MySQL 8, query cache Redis |
| Sokongan acara berbilang hari | ✅ Sangat sesuai | Eloquent relationships menangani struktur acara-sesi dengan elegan |
| 50,000 pengguna serentak | ✅ Boleh dicapai | Dengan Laravel Octane + Redis cache + load balancer |
| Audit log keselamatan | ✅ Sangat sesuai | Laravel Auditing package atau Spatie Activity Log |

**Verdict:** Laravel + MySQL adalah pilihan yang **sangat sesuai** untuk sistem ini. Tiada keperluan kritikal yang tidak dapat ditangani oleh stack ini. Pertimbangan untuk teknologi alternatif (PostgreSQL, Node.js) hanya wajar jika sistem berkembang merangkumi keperluan analitik kompleks atau geolokasi sangat lanjutan pada fasa kemudian.

### 11.3 Versi & Komponen Teknologi Spesifik

**Lapisan Belakang:**

- **PHP 8.2+** untuk prestasi dan fitur bahasa moden (typed properties, enums, readonly classes)
- **Laravel 11.x** sebagai rangka kerja teras (versi LTS dengan sokongan keselamatan sehingga 2026+)
- **Laravel Octane** dengan **Swoole** atau **FrankenPHP** untuk meningkatkan throughput sehingga 10x ganda berbanding PHP-FPM tradisional — penting untuk mengendalikan ratusan imbasan QR serentak
- **Laravel Sanctum** untuk pengesahan API berasaskan token (apl mudah alih)
- **Laravel Breeze** atau **Jetstream** untuk pengesahan portal web
- **Laravel Reverb** untuk komunikasi WebSocket masa nyata (papan pemuka kehadiran)
- **Laravel Horizon** untuk pemantauan visual baris gilir kerja
- **Spatie Laravel Permission** untuk pengurusan peranan dan kebenaran granular

**Pakej Khusus Sistem:**

- `simplesoftwareio/simple-qrcode` atau `endroid/qr-code` — penjanaan QR Code
- `tymon/jwt-auth` atau Laravel Sanctum — token bertandatangan untuk QR
- `barryvdh/laravel-dompdf` — penjanaan sijil PDF ringkas
- `spatie/browsershot` — penjanaan sijil PDF dengan reka bentuk kompleks (menggunakan Headless Chrome)
- `maatwebsite/excel` — eksport laporan ke XLSX
- `spatie/laravel-activitylog` — audit log lengkap
- `pragmarx/google2fa-laravel` — pengesahan dua faktor (2FA)
- `laravel/socialite` — pada fasa kemudian untuk SSO dengan direktori negeri

**Pangkalan Data & Storan:**

- **MySQL 8.0+** atau **MariaDB 10.6+** sebagai pangkalan data utama
- **Redis 7.x** untuk cache, sesi, baris gilir kerja, dan kunci kadar imbasan QR
- **MinIO** (S3-compatible, self-hosted) atau pelayan fail dalaman untuk storan sijil PDF, logo jabatan, dan lampiran acara

**Lapisan Hadapan (Web Portal Pentadbir/Penyelaras):**

Tiga pendekatan boleh dipilih, dengan keutamaan seperti berikut:

**Opsyen A (DISYORKAN) — Inertia.js + Vue 3:** Memberikan pengalaman SPA yang lancar tanpa perlu membina API berasingan. Pasukan Laravel boleh kekal dalam ekosistem yang sama, dan pembangunan lebih pantas. Sesuai untuk kebanyakan portal pentadbir.

**Opsyen B — Laravel Livewire 3:** Komponen reaktif tanpa menulis JavaScript banyak. Sangat pantas untuk membina papan pemuka mudah dan borang. Pilihan terbaik jika pasukan PHP tidak biasa dengan Vue/React.

**Opsyen C — SPA Berasingan (Vue 3 atau React + Vite):** Berkomunikasi dengan Laravel sebagai API sahaja. Lebih fleksibel dan membolehkan apl web dan apl mudah alih kongsi API yang sama, tetapi memerlukan lebih banyak kerja pembangunan.

**Cadangan akhir untuk PRD ini:** Mulakan dengan **Inertia.js + Vue 3** untuk portal Penyelaras dan Admin (kepantasan pembangunan), serta **API berasingan dengan Laravel Sanctum** untuk apl mudah alih peserta. Penggayaan menggunakan **Tailwind CSS 3.x** untuk konsistensi reka bentuk. Komponen UI: **PrimeVue** atau **shadcn-vue**.

**Aplikasi Mudah Alih (Peserta):**

Bagi apl peserta yang fungsi utamanya ialah imbas QR dan lihat sijil, dua pendekatan utama:

**Pendekatan A (Fasa MVP) — Progressive Web App (PWA):** Bina menggunakan Laravel + service worker. Peserta tidak perlu muat turun apa-apa apl — mereka hanya buka pelayar telefon, log masuk sekali, dan boleh imbas QR menggunakan kamera asli. Kelebihan: tiada kelulusan App Store/Play Store, lebih cepat untuk dilancarkan, lebih murah. Kelemahan: notifikasi push terhad pada iOS.

**Pendekatan B (Fasa 3) — Apl Native dengan Flutter 3.x:** Satu kod sumber untuk Android dan iOS, prestasi hampir native, sokongan baik untuk imbasan QR melalui pakej `mobile_scanner`. Notifikasi push penuh pada kedua-dua platform. Komuniti Flutter aktif di Malaysia.

**Cadangan:** Lancarkan **PWA dahulu** dalam Fasa 2 untuk kepantasan dan kos rendah, kemudian bina **apl Flutter native** dalam Fasa 3 untuk pengalaman yang lebih kaya dan notifikasi push penuh.

### 11.4 Persekitaran Pengeluaran dan DevOps

Pelayan web menggunakan **Nginx + PHP-FPM** sebagai konfigurasi tradisional, atau **FrankenPHP** sebagai alternatif moden yang menyatukan kedua-duanya dengan prestasi lebih tinggi. Sistem operasi pelayan adalah **Ubuntu 22.04 LTS** atau **RHEL 9** mengikut polisi BPM Negeri Kedah. **Docker** boleh digunakan untuk konsistensi antara persekitaran pembangunan, ujian, dan pengeluaran, walaupun Laravel boleh juga dideploy secara langsung pada pelayan tradisional.

Untuk CI/CD, **GitLab CI** atau **GitHub Actions** boleh digunakan untuk auto-deploy selepas ujian lulus. Pemantauan ralat dan prestasi menggunakan **Sentry** untuk pengesanan ralat pengeluaran, **Laravel Telescope** untuk debug semasa pembangunan, dan **Grafana + Prometheus** untuk metrik sistem peringkat infrastruktur.

Hosting akhir adalah pada **MyGovCloud** atau pusat data SUK Kedah dengan persekitaran berasingan untuk pembangunan, ujian, dan pengeluaran, mengikut polisi MAMPU.

### 11.5 Perbandingan dengan Stack Alternatif

Untuk ketelusan, berikut perbandingan ringkas antara Laravel + MySQL dengan dua alternatif yang biasanya dipertimbangkan:

| Aspek | Laravel + MySQL (DISYORKAN) | Node.js + PostgreSQL | Python (Django) + PostgreSQL |
|-------|------------------------------|----------------------|------------------------------|
| Ekosistem pembangun di Malaysia | ⭐⭐⭐⭐⭐ Sangat luas | ⭐⭐⭐ Sederhana | ⭐⭐⭐ Sederhana |
| Kepantasan pembangunan | ⭐⭐⭐⭐⭐ Sangat pantas | ⭐⭐⭐⭐ Pantas | ⭐⭐⭐⭐⭐ Sangat pantas |
| Prestasi WebSocket masa nyata | ⭐⭐⭐⭐ Reverb mantap | ⭐⭐⭐⭐⭐ Native | ⭐⭐⭐ Memerlukan kerja tambahan |
| Geolokasi & spatial | ⭐⭐⭐ MySQL spatial mencukupi | ⭐⭐⭐⭐⭐ PostGIS unggul | ⭐⭐⭐⭐⭐ PostGIS unggul |
| Kos pembangunan | ⭐⭐⭐⭐⭐ Rendah | ⭐⭐⭐ Sederhana | ⭐⭐⭐⭐ Rendah-sederhana |
| Kos hosting | ⭐⭐⭐⭐⭐ Sangat rendah | ⭐⭐⭐ Sederhana | ⭐⭐⭐⭐ Rendah |
| Kebolehselenggaraan jangka panjang | ⭐⭐⭐⭐⭐ Komuniti aktif Malaysia | ⭐⭐⭐ Bergantung pasukan | ⭐⭐⭐⭐ Komuniti stabil |
| Penyelarasan dengan sistem kerajaan sedia ada | ⭐⭐⭐⭐⭐ Banyak sistem PHP/MySQL | ⭐⭐ Kurang biasa | ⭐⭐⭐ Sederhana |

**Kesimpulan:** Laravel + MySQL menang dalam dimensi yang paling penting untuk konteks ini — ekosistem pembangun tempatan, kos, dan integrasi dengan sistem kerajaan. Walaupun PostgreSQL secara teknikal lebih kuat dalam aspek geolokasi, keperluan sistem ini tidak melebihi keupayaan MySQL spatial.

### 11.6 Diagram Stack Lengkap

```
┌─────────────────────────────────────────────────────┐
│  LAPISAN PERSEMBAHAN                                 │
│  ┌──────────────────────┐  ┌──────────────────────┐ │
│  │ Web Portal           │  │ Mobile (PWA→Flutter) │ │
│  │ Inertia.js + Vue 3   │  │ mobile_scanner pkg   │ │
│  │ Tailwind CSS         │  │ QR + Push Notif      │ │
│  └──────────┬───────────┘  └──────────┬───────────┘ │
└─────────────┼──────────────────────────┼─────────────┘
              │       HTTPS / TLS 1.3    │
              ▼                          ▼
┌─────────────────────────────────────────────────────┐
│  LAPISAN APLIKASI                                    │
│  ┌─────────────────────────────────────────────┐    │
│  │  Laravel 11 (PHP 8.2+) + Octane (Swoole)    │    │
│  │  ────────────────────────────────────────    │    │
│  │  • REST API + Sanctum (auth token)          │    │
│  │  • Eloquent ORM + Migrations                │    │
│  │  • Queue + Horizon (e-mel, sijil, SMS)      │    │
│  │  • Reverb (WebSocket masa nyata)            │    │
│  │  • Scheduler (peringatan, kira jam latihan) │    │
│  │  • Spatie Activity Log (audit)              │    │
│  └─────────────────┬───────────────────────────┘    │
└────────────────────┼─────────────────────────────────┘
                     │
┌────────────────────┼─────────────────────────────────┐
│  LAPISAN DATA      │                                  │
│  ┌─────────────────▼──┐  ┌──────────┐  ┌──────────┐  │
│  │  MySQL 8.0         │  │  Redis 7 │  │  MinIO   │  │
│  │  (utama)           │  │  (cache, │  │  (sijil, │  │
│  │  - InnoDB engine   │  │   queue, │  │   logo,  │  │
│  │  - Spatial index   │  │   sesi)  │  │   fail)  │  │
│  │  - Replication     │  │          │  │          │  │
│  └────────────────────┘  └──────────┘  └──────────┘  │
└──────────────────────────────────────────────────────┘
                     │
┌────────────────────┼─────────────────────────────────┐
│  LAPISAN PERKHIDMATAN LUARAN                         │
│  ┌──────────┐ ┌──────────┐ ┌──────────────────────┐  │
│  │ E-mel    │ │ SMS      │ │ Firebase Cloud       │  │
│  │ MyGovUC/ │ │ Macro-   │ │ Messaging (push)     │  │
│  │ SES      │ │ kiosk    │ │                      │  │
│  └──────────┘ └──────────┘ └──────────────────────┘  │
│  ┌──────────────────────────────────────────────┐    │
│  │ Fasa Kemudian: HRMIS, eOperasi, e-Pembelajaran│   │
│  │ INTAN, Direktori Aktif Negeri Kedah (SSO)    │    │
│  └──────────────────────────────────────────────┘    │
└──────────────────────────────────────────────────────┘
```

### 11.7 Pertimbangan Akhir

Pemilihan akhir stack teknologi adalah keputusan strategik yang perlu dibuat oleh pasukan teknikal SUK Kedah dan vendor pembangunan dengan persetujuan Pejabat ICT Negeri. PRD ini mencadangkan **Laravel 11 + MySQL 8** sebagai pilihan utama berdasarkan analisis di atas, tetapi keputusan akhir patut mengambil kira: kepakaran pasukan dalaman, polisi piawaian ICT Negeri Kedah, infrastruktur sedia ada, dan pelan integrasi jangka panjang dengan sistem kerajaan negeri yang lain.

---

## 12. Model Data (Skema Tahap Tinggi)

**Jadual `users`:** id (UUID), no_kp, no_pekerja, nama, emel, no_telefon, kata_laluan_hash, jabatan_id, jawatan, gred, peranan, status_aktif, dicipta_pada, dikemaskini_pada.

**Jadual `jabatan`:** id, kod_jabatan, nama_jabatan, ptj_induk, alamat, logo_url.

**Jadual `acara`:** id (UUID), no_rujukan, tajuk, kategori, penerangan, tarikh_mula, tarikh_tamat, lokasi, **jenis_acara** (fizikal/dalam_talian/hibrid), kuota, status, dicipta_oleh, jabatan_id, qr_token, qr_mod (statik/dinamik), radius_geo_meter, koordinat_lat, koordinat_lng, **mod_gantian** (tidak_dibenarkan/dengan_kelulusan/terbuka), **pengesahan_berterusan_aktif** (boolean), **bilangan_check_in_rawak**, **ambang_kehadiran_sebahagian** (peratus), **pautan_meeting_url** (untuk dalam talian/hibrid), **adalah_berbilang_hari** (boolean), **ambang_sijil_peratus** (lalai 80), **kategori_jam_latihan** (kursus_wajib/kursus_sukarela/mesyuarat/bengkel/seminar/latihan_khusus), **adalah_siri** (boolean), **id_acara_induk_siri** (untuk siri).

**Jadual `sesi` (BAHARU):** id (UUID), acara_id, urutan_sesi, tajuk_sesi (mis. "Hari 1 — Sesi Pagi"), tarikh, masa_mula, masa_tamat, lokasi_sesi (jika berbeza dari acara), jam_latihan_dikira, qr_token_sesi, qr_mod_sesi, adalah_wajib (boolean), tempoh_sah_imbas_sebelum_minit, tempoh_sah_imbas_selepas_minit, status_sesi (akan_datang/aktif/selesai/dibatalkan).

**Jadual `peserta_acara`:** id, acara_id, pengguna_id, status_jemputan (dijemput/sah/tolak/gantian), **kategori_kehadiran** (fizikal/dalam_talian — untuk acara hibrid), **token_pautan_unik** (untuk acara dalam talian), **tarikh_tamat_token**, dicipta_pada.

**Jadual `kehadiran_sesi` (BAHARU):** id, sesi_id, pengguna_id, peserta_acara_id, masa_daftar_masuk, masa_daftar_keluar, koordinat_imbas, alat_imbas, ip_imbas, status_sah, **kaedah_kehadiran** (qr_fizikal/qr_skrin/pautan_unik/pengesahan_berterusan/api_meeting), **adalah_wakil_gantian** (boolean), **id_peserta_asal** (FK ke users), **jam_latihan_dikreditkan**, **peratus_pengesahan** (untuk pengesahan berterusan).

**Jadual `kehadiran`:** id, acara_id, pengguna_id, **jumlah_sesi_wajib**, **sesi_wajib_dihadiri**, **peratus_kehadiran_dikira**, **jumlah_jam_latihan_acara**, **status_kelayakan_sijil** (penuh/sebahagian/tidak_layak), tarikh_dikira.

**Jadual `gantian` (BAHARU di v1.1, dikemas kini di v1.2):** id, acara_id, **sesi_id** (NULL jika gantian seluruh acara, isi jika gantian per sesi), peserta_asal_id, wakil_id, alasan, jenis_gantian (pra_acara/walk_in/auto_terbuka/per_sesi), status (menunggu/diluluskan/ditolak), penyelaras_lulus_id, masa_permohonan, masa_keputusan, ulasan_penyelaras.

**Jadual `pengesahan_berterusan` (BAHARU di v1.1):** id, kehadiran_sesi_id, masa_dijadual, masa_dipaparkan, masa_dijawab, status (dijawab/terlepas/belum_dipaparkan).

**Jadual `sijil`:** id, kehadiran_id, url_pdf, kod_pengesahan, dijana_pada, **status_kehadiran** (penuh/sebahagian), **peratus_kehadiran**, **jenis_sijil** (peserta_penuh/peserta_sebahagian/wakil_gantian), **senarai_sesi_dihadiri_json**.

**Jadual `jam_latihan_tahunan` (BAHARU — view atau jadual ringkasan):** id, pengguna_id, tahun, jumlah_jam, jam_kursus_wajib, jam_kursus_sukarela, jam_mesyuarat, jam_bengkel, jam_seminar, jam_latihan_khusus, sasaran_jam, peratus_pencapaian, dikemaskini_pada.

**Jadual `peranan` (BAHARU di v1.4):** id, kod_peranan (contoh: super_admin, admin_jabatan), nama_peranan, penerangan, adalah_lalai_sistem (boolean), boleh_dipadam (boolean), tahap_hierarki (integer untuk perbandingan), dicipta_oleh, dicipta_pada, dikemaskini_pada.

**Jadual `kebenaran` (BAHARU di v1.4):** id, kod_kebenaran (contoh: event.create, user.delete), nama_kebenaran, kategori_modul, penerangan, adalah_sensitif (boolean — untuk laporan kebenaran kritikal).

**Jadual `peranan_kebenaran` (BAHARU di v1.4 — pivot):** peranan_id, kebenaran_id, dicipta_pada.

**Jadual `pengguna_peranan` (BAHARU di v1.4):** id, pengguna_id, peranan_id, **skop_jenis** (semua_negeri/jabatan_tertentu/sendiri), **skop_jabatan_id** (NULL jika seluruh negeri), tarikh_mula, tarikh_tamat (NULL jika kekal), status (aktif/dicabut/tamat_tempoh), adalah_pemangku (boolean), rujukan_surat_pelantikan, dilantik_oleh, dilantik_pada, sebab_pencabutan.

**Jadual `delegasi_peranan` (BAHARU di v1.4):** id, pemberi_id (pengguna), penerima_id (pengguna), peranan_id (peranan yang didelegasi), **kebenaran_terpilih_json** (NULL jika seluruh peranan, atau senarai kebenaran subset), tarikh_mula, tarikh_tamat, alasan, status (menunggu/diluluskan/ditolak/aktif/tamat_tempoh/dibatalkan), penerima_kelulusan_id, masa_kelulusan, ulasan.

**Jadual `pemilikan_resource` (BAHARU di v1.4):** id, pengguna_id, jenis_resource (event/session/report), resource_id, jenis_pemilikan (pencipta/penyelaras/pengerusi), dicipta_pada. *Jadual ini menyokong resource-level permissions di mana pengguna mempunyai kebenaran khusus pada resource tertentu walaupun peranan global mereka tidak memberi akses am.*

**Jadual `users`:** id (UUID), no_kp, no_pekerja, nama, emel, no_telefon, kata_laluan_hash, jabatan_id, jawatan, gred, peranan, status_aktif, dicipta_pada, dikemaskini_pada. *Catatan: medan `peranan` dalam jadual `users` adalah peranan utama untuk paparan; senarai peranan penuh disimpan dalam `pengguna_peranan`.*

**Jadual `audit_log`:** id, pengguna_id, tindakan, jenis_objek, id_objek, butiran_json, ip, masa. *Catatan: tindakan RBAC seperti pelantikan peranan, pencabutan, delegasi, dan perubahan kebenaran direkodkan dengan butiran lengkap (peranan terlibat, sasaran, pelaku) untuk pengauditan.*

---

## 13. Reka Bentuk Antara Muka (UI/UX) — Garis Panduan

Reka bentuk visual akan mengikut **Design System Kerajaan Malaysia (MyDS)** atau garis panduan korporat negeri Kedah, menggunakan palet warna rasmi negeri (kuning kerajaan dan hijau). Antara muka dioptimumkan untuk peranti mudah alih terlebih dahulu (mobile-first) memandangkan majoriti imbasan QR berlaku pada telefon.

Halaman peserta dikekalkan minimalis: skrin imbasan QR ialah tindakan utama, dengan butang besar dan jelas. Halaman pentadbir/penyelaras pula menggunakan susun atur papan pemuka dengan kad statistik di bahagian atas dan jadual acara di bawah. Borang pendaftaran acara menggunakan pendekatan langkah demi langkah (wizard) untuk mengelakkan kekeliruan pengguna.

Aksesibiliti ialah keutamaan: saiz teks minimum 14px, kontras warna mencukupi, label borang yang jelas, dan mesej ralat yang menjelaskan tindakan susulan secara spesifik.

---

## 14. Integrasi dengan Sistem Sedia Ada

Pada Fasa awal, sistem akan beroperasi secara berdiri sendiri tetapi menyokong eksport data untuk pemindahan ke sistem lain. Pada fasa kemudian, integrasi yang dirancang adalah:

- **HRMIS / eOperasi:** Pengesahan identiti penjawat awam dan auto-isi profil
- **e-Pembelajaran INTAN:** Sinkronisasi kursus wajib dan kemas kini rekod latihan
- **Direktori Aktif Negeri Kedah:** Single Sign-On (SSO) menggunakan SAML 2.0 atau OAuth 2.0
- **MyGovUC:** Penghantaran e-mel rasmi
- **Sistem LNPT Jabatan:** Eksport rekod kehadiran kursus untuk penilaian prestasi tahunan

---

## 15. Keselamatan dan Privasi

Pengesahan pengguna menggunakan kombinasi kata laluan kuat (minimum 12 aksara, gabungan huruf besar/kecil/angka/simbol) dan 2FA wajib bagi peranan Admin. Token sesi tamat tempoh selepas 30 minit tidak aktif. Semua kata laluan disimpan menggunakan algoritma bcrypt atau Argon2 dengan salt unik.

QR Code menggunakan JWT bertandatangan dengan kunci RSA 2048-bit. Token QR dinamik tamat tempoh selepas 30 saat untuk mencegah pengguna berkongsi imej QR dengan rakan yang tidak hadir. Imbasan QR dari luar radius geolokasi yang dibenarkan akan ditolak dan dilog untuk audit.

Data peribadi (No. KP, e-mel, no. telefon) disulitkan pada peringkat lajur pangkalan data. Sandaran data harian dilakukan ke lokasi geografi berasingan, dengan tempoh penyimpanan mengikut polisi rekod awam (Akta Arkib Negara 2003).

Notis Privasi PDPA dipaparkan pada pendaftaran pertama, dengan persetujuan jelas untuk pemprosesan data. Pengguna boleh memohon eksport atau pemadaman data peribadi mengikut hak yang termaktub dalam PDPA.

---

## 16. Metrik Kejayaan (KPI)

Kejayaan e-DAFTAR Kedah akan diukur menggunakan metrik berikut dalam tempoh 12 bulan selepas pelancaran penuh:

| KPI | Sasaran 6 Bulan | Sasaran 12 Bulan |
|-----|------------------|-------------------|
| Bilangan jabatan menggunakan sistem | 15 | 30+ |
| Bilangan acara didaftarkan | 500 | 2,000+ |
| Bilangan rekod kehadiran | 10,000 | 50,000+ |
| Pengurangan masa daftar masuk (vs manual) | 70% | 80% |
| Skor kepuasan pengguna (NPS) | ≥ 30 | ≥ 50 |
| Ketepatan rekod kehadiran | 99% | 100% |
| Insiden keselamatan | 0 kritikal | 0 kritikal |
| Ketersediaan sistem | 99.0% | 99.5% |

---

## 17. Pelan Pelaksanaan (Roadmap)

**Fasa 1 — Discovery & Reka Bentuk (Bulan 1–2):** Workshop dengan pemegang kepentingan, persijilan keperluan terperinci, reka bentuk UI/UX, dan persetujuan seni bina teknikal.

**Fasa 2 — Pembangunan MVP (Bulan 3–6):** Modul pengguna, modul acara, penjanaan QR, imbasan QR asas, papan pemuka kehadiran ringkas, dan laporan asas. MVP dilancarkan kepada 3 jabatan perintis.

**Fasa 3 — Penambahbaikan & Skala (Bulan 7–9):** Modul sijil, notifikasi automatik penuh, geolokasi, papan pemuka lanjutan, apl mudah alih native, dan onboarding 12 jabatan tambahan.

**Fasa 4 — Integrasi & Pengoptimuman (Bulan 10–12):** SSO dengan direktori negeri, integrasi awal HRMIS, optimasi prestasi, dan ujian penembusan luaran.

**Fasa 5 — Pelancaran Penuh (Bulan 13+):** Onboarding semua jabatan negeri Kedah, latihan pengguna massal, dan penyenggaraan berterusan.

---

## 18. Risiko & Mitigasi

| Risiko | Kesan | Kebarangkalian | Mitigasi |
|--------|-------|----------------|----------|
| Pengguna kongsi QR Code untuk daftar masuk rakan tidak hadir | Tinggi | Tinggi | QR Dinamik (berputar 30s) + pengesahan geolokasi |
| Sambungan internet lemah di lokasi luar bandar | Sederhana | Sederhana | Mod luar talian terhad pada apl, sync apabila online |
| Penolakan pengguna terhadap teknologi baharu | Sederhana | Sederhana | Sesi latihan, video tutorial, dan kempen perubahan oleh juara dalaman jabatan |
| Pelanggaran data peribadi | Sangat Tinggi | Rendah | Penyulitan, audit keselamatan, ujian penembusan tahunan, latihan kesedaran kakitangan |
| Kelewatan integrasi HRMIS | Sederhana | Tinggi | Reka bentuk fasa 1 sebagai sistem berdiri sendiri; integrasi fasa 3 |
| Kesalahan klasifikasi data biometrik (geolokasi) di bawah PDPA | Tinggi | Rendah | Konsultasi Suruhanjaya Perlindungan Data Peribadi awal; persetujuan jelas |
| Penyalahgunaan sistem gantian (peserta sengaja tukar pada saat akhir untuk elak kursus) | Sederhana | Sederhana | Had bilangan gantian per peserta per tahun; laporan trend kepada Pengarah |
| Penyelaras lambat lulus permohonan walk-in, peserta menunggu lama | Sederhana | Tinggi | Notifikasi multi-saluran (push, SMS, e-mel); auto-eskalasi kepada Admin Jabatan selepas 10 minit |
| Peserta dalam talian "log masuk lalu tinggal" — kehadiran palsu | Tinggi | Tinggi | Pengesahan berterusan rawak untuk sesi panjang; integrasi API platform mesyuarat (fasa lanjutan) |
| Pautan unik dalam talian tersebar/dikongsi di WhatsApp | Sederhana | Sederhana | Pengikatan token kepada No. KP & sesi log masuk; satu sesi aktif per peserta sahaja |
| Sambungan internet peserta terputus semasa pengesahan berterusan | Sederhana | Sederhana | Tempoh tindak balas 3 minit; mod toleransi (1 terlepas dibenarkan); rayuan manual kepada Penyelaras |
| Peserta acara berbilang hari hadir hari pertama untuk imbas QR sahaja, kemudian tinggal | Tinggi | Tinggi | Wajibkan check-in & check-out per sesi; pengesahan berterusan untuk sesi panjang; QR Dinamik untuk anti-perkongsian |
| Logik pengiraan jam latihan menjadi tidak konsisten apabila ada gantian per sesi | Sederhana | Sederhana | Reka bentuk model data dengan kreditasi jam pada peringkat `kehadiran_sesi`, bukan `kehadiran` agregat; ujian unit komprehensif untuk semua kombinasi |
| Pertikaian tentang jam latihan dikira (peserta dakwa hadir tetapi rekod kosong) | Tinggi | Sederhana | Sistem rayuan formal dengan bukti sokongan; audit log lengkap setiap imbasan; SOP semakan dalam masa 14 hari |
| Penyelaras terlupa konfigurasi sesi dengan betul (mis. terlupa tanda sesi sebagai wajib) | Sederhana | Tinggi | Wizard pendaftaran berstruktur; ringkasan pra-pelancaran wajib dilihat; templat acara siap pakai |
| Acara berbilang hari dibatalkan separuh jalan (mis. cuti darurat, hujan lebat) | Sederhana | Rendah | Logik pro-rata sijil; notifikasi automatik kepada peserta; opsyen Penyelaras untuk konfigurasi tindakan susulan |
| Pengguna yang dipindahkan/diberhentikan masih boleh akses sistem dengan token aktif | Tinggi | Sederhana | Pencabutan akses dalam 60 saat melalui pengesahan token setiap permintaan; integrasi HRMIS untuk auto-cabut peranan apabila status pekerja berubah |
| Privilege escalation — pengguna mendapat kebenaran lebih daripada yang sepatutnya | Sangat Tinggi | Rendah | Penegakan deny-by-default; ujian penembusan tahunan; semakan kuartal kebenaran sensitif; prinsip least privilege |
| Konflik skop antara peranan menyebabkan akses tidak dijangka | Sederhana | Sederhana | Logik intersection skop yang jelas; ujian unit menyeluruh untuk kombinasi peranan; dokumentasi tingkah laku konflik |
| Delegasi tidak dicabut selepas tarikh tamat kerana kegagalan cron job | Tinggi | Rendah | Sistem berlapis: cron job utama + fallback semakan masa nyata pada setiap permintaan API |
| Auditor secara tidak sengaja diberi kebenaran tulis | Tinggi | Rendah | Peranan auditor dilindungi pada peringkat kod (hard-coded deny untuk write actions), bukan hanya konfigurasi peranan |
| Penyelaras kehilangan akses kepada acara sendiri apabila peranan global dicabut | Sederhana | Sederhana | Resource-level permissions kekal walaupun peranan global dicabut, melainkan dicabut secara eksplisit |

---

## 19. Andaian dan Kebergantungan

Sistem ini diandaikan akan dihos pada infrastruktur kerajaan yang memenuhi standard MyMIS. Penjawat awam diandaikan mempunyai akses kepada telefon pintar dengan kamera dan internet (yang merupakan andaian munasabah pada 2026 berdasarkan kadar penembusan telefon pintar Malaysia). Setiap jabatan akan melantik sekurang-kurangnya seorang Admin Jabatan dan seorang juara perubahan untuk membantu onboarding kakitangan.

Kebergantungan utama adalah: (1) kelulusan dasar ICT Negeri Kedah, (2) peruntukan pembiayaan untuk Fasa 1–4, (3) kerjasama jabatan-jabatan untuk membekalkan data pengguna asas, dan (4) persediaan infrastruktur pelayan oleh BPM Negeri.

---

## 20. Lampiran

### A. Glosari Istilah

- **PTJ:** Pusat Tanggungjawab
- **LNPT:** Laporan Nilaian Prestasi Tahunan
- **MAMPU:** Unit Pemodenan Tadbiran dan Perancangan Pengurusan Malaysia
- **PDPA:** Personal Data Protection Act 2010
- **SUK:** Setiausaha Kerajaan
- **MyMIS:** Malaysian Public Sector Management of ICT Security
- **MyDS:** Design System Kerajaan Malaysia

### B. Rujukan

- Akta Perlindungan Data Peribadi 2010
- Pekeliling Kemajuan Pentadbiran Awam (PKPA)
- Garis Panduan Pengkomputeran MAMPU
- Standard WCAG 2.1
- Akta Arkib Negara 2003

### C. Sejarah Semakan Dokumen

| Versi | Tarikh | Pindaan | Disediakan Oleh |
|-------|--------|---------|------------------|
| 1.0 | 1 Mei 2026 | Draf awal | _(Untuk diisi)_ |
| 1.1 | 1 Mei 2026 | Penambahan Modul Pengurusan Gantian (Seksyen 9.7) dengan 3 mod gantian; Penambahan Modul Acara Dalam Talian dan Hibrid (Seksyen 9.8) dengan pautan unik, QR pada skrin, dan pengesahan berterusan; Kemas kini model data dengan jadual `gantian` dan `pengesahan_berterusan`, serta medan tambahan dalam `acara`, `peserta_acara`, `kehadiran`, dan `sijil`; Penambahan US-07 hingga US-12; Penambahan aliran 8.4–8.7; Penambahan ciri F-21 hingga F-29; Penambahan 5 risiko baharu berkaitan gantian dan acara dalam talian | _(Untuk diisi)_ |
| 1.2 | 1 Mei 2026 | Penambahan Modul Acara Berbilang Hari dan Sesi (Seksyen 9.9) dengan struktur acara induk + sesi, gantian per sesi, ambang sijil boleh dikonfigur, sokongan acara siri; Penambahan Modul Penjejakan Jam Latihan untuk LNPT (Seksyen 9.10); Pengenalan jadual baharu `sesi`, `kehadiran_sesi`, `jam_latihan_tahunan`; Pengubahsuaian struktur `kehadiran` daripada per-acara kepada agregat dengan kehadiran sebenar dipindah ke `kehadiran_sesi`; Penambahan US-13 hingga US-17; Penambahan aliran 8.8–8.10; Penambahan ciri F-30 hingga F-39; Penambahan 6 risiko baharu | _(Untuk diisi)_ |
| 1.3 | 1 Mei 2026 | Penambahbaikan Seksyen 11 (Seni Bina Teknikal) dengan cadangan stack spesifik **Laravel 11 + MySQL 8.0** sebagai pilihan utama; Penambahan analisis kesesuaian setiap keperluan kritikal terhadap Laravel + MySQL; Senarai pakej PHP/Laravel khusus untuk QR, PDF, audit log, 2FA; Penilaian frontend dengan Inertia.js + Vue 3 sebagai cadangan utama; Strategi mobile dengan PWA dahulu, kemudian Flutter; Perbandingan dengan stack alternatif (Node.js, Python); Justifikasi pemilihan berasaskan ekosistem pembangun Malaysia, kos, dan integrasi sistem kerajaan sedia ada | _(Untuk diisi)_ |
| 1.4 | 1 Mei 2026 | Penambahan Modul RBAC dan Pengurusan Akses (Seksyen 9.11) dengan 9 peranan lalai (Super Admin, Admin Negeri, Admin Jabatan, Penyelaras, Pengerusi Acara, Ketua Jabatan, Pegawai Penilai, Auditor, Peserta); Senarai kebenaran granular merentas 11 kategori modul (user, event, session, attendance, substitution, certificate, report, training_hours, rbac, system); Matriks peranan vs kebenaran terperinci; Sokongan peranan tersuai, multi-peranan, skop jabatan, resource-level permissions; Mekanisme delegasi sementara dan pelantikan pemangku jawatan; Pengenalan jadual baharu `peranan`, `kebenaran`, `peranan_kebenaran`, `pengguna_peranan`, `delegasi_peranan`, `pemilikan_resource`; Penambahan US-18 hingga US-23; Penambahan aliran 8.11; Penambahan ciri F-40 hingga F-50; Penambahan 7 risiko keselamatan baharu | _(Untuk diisi)_ |

---

*Dokumen ini ialah draf untuk semakan pemegang kepentingan. Maklum balas hendaklah dihantar kepada pemilik produk sebelum tarikh penyelesaian Fasa 1.*
