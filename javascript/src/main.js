import {
  getAllDataMahasiswa,
  deleteDataMahasiswa,
} from "./api/mahasiswaServices.js";

// retrive data
const renderDataMahasiwa = async () => {
  const cardContainer = document.querySelector(".card-container");
  try {
    const listMahasiswa = await getAllDataMahasiswa();
    const allCard = listMahasiswa
      .map((mahasiswa, i) => {
        return `
                    <div class="card">
                        <div class="card-header">
                        <h3>Kartu Mahasiswa - INSTIKI</h3>
                        </div>
                        <div class="card-body">
                        <div class="data-item">
                            <label>Nama:</label>
                            <span >${mahasiswa["nama_mhs"]}</span>
                        </div>
                        <div class="data-item">
                            <label>NIM:</label>
                            <span >${mahasiswa["nim"]}</span>
                        </div>
                        <div class="data-item">
                            <label>ID Prodi:</label>
                            <span >${mahasiswa["id_prodi"]}</span>
                        </div>
                        <div class="data-item">
                            <label>Email:</label>
                            <span>${mahasiswa["email"]}</span>
                        </div>
                        </div>
                        <div class="card-actions">
                            <a href="./pages/update-mahasiswa.html?id=${mahasiswa["id"]}">
                              <button id="btn-update" class="btn btn-update-add" data-id="${mahasiswa["id"]}" value="${mahasiswa["id"]}" >Edit</button>
                            </a>
                            
                            <button id="btn-delete" class="btn btn-delete" data-id="${mahasiswa["id"]}" type="submit">Hapus</button>
                        </div>
                    </div>
                `;
      })
      .join("");

    cardContainer.innerHTML = allCard;
  } catch (error) {
    console.error("gagal memuat data");
  }
};

// show information / feedback
document.addEventListener("DOMContentLoaded", () => {
  const showInformation = document.querySelector(".show-information");

  const flashMessageJSON = sessionStorage.getItem("flashMessage");

  if (flashMessageJSON) {
    const flashMessage = JSON.parse(flashMessageJSON);

    flashMessage ? (showInformation.innerText = flashMessage.text) : "";

    sessionStorage.removeItem("flashMessage");
  }
});

// delete data
document.body.addEventListener("click", async (e) => {
  if (e.target.classList.contains("btn-delete")) {
    const mahasiswaId = e.target.dataset.id;

    const isConfirmed = window.confirm(
      `Apakah Anda yakin ingin menghapus mahasiswa dengan ID "${mahasiswaId}"?`
    );

    if (isConfirmed) {
      const results = await deleteDataMahasiswa(mahasiswaId);
      if (results.status === 200) {
        alert("Data berhasil di hapus");
        window.location.reload();
      }
    }
  }
});

renderDataMahasiwa();
