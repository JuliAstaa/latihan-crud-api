import { getAllDataProdi } from "./api/prodiServices.js";
import { createDataMahasiswa } from "./api/mahasiswaServices.js";
import { validateMahasiswaForm } from "./utils/validator.js";

const createDataMhs = async (dataMahasiswa) => {
  try {
    const apiResponse = await createDataMahasiswa(dataMahasiswa);

    if (apiResponse.status === 201) {
      sessionStorage.setItem(
        "flashMessage",
        JSON.stringify({
          type: "success",
          text: apiResponse.message || "Data mahasiswa berhasil ditambahkan!",
        })
      );
      window.location.href = "../index.html";
    } else {
      return apiResponse.errors;
    }
  } catch (error) {
    console.error(error);
  }
};

// Bungkus semua logika di dalam DOMContentLoaded
document.addEventListener("DOMContentLoaded", () => {
  const prodiOption = document.getElementById("id_prodi");

  const getDataProdi = async () => {
    try {
      const dataProdi = await getAllDataProdi();
      const listProdi = dataProdi
        .map((data) => {
          return `<option value="${data.id}">${data.kode_prodi} -- ${data.prodi}</option>`;
        })
        .join("");
      prodiOption.innerHTML += listProdi;
    } catch (error) {
      console.error("Gagal memuat data prodi:", error);
      prodiOption.innerHTML += '<option value="">Gagal memuat prodi</option>';
    }
  };

  getDataProdi();

  // submit
  const form = document.getElementById("formTambahMahasiswa"); // PERBAIKI TYPO
  const btnSubmit = document.getElementById("submit");
  const errorNim = document.getElementById("error-nim");
  const errorNama = document.getElementById("error-nama");
  const errorIdProdi = document.getElementById("error-idProdi");
  const errorEmail = document.getElementById("error-email");

  form.addEventListener("submit", async (e) => {
    e.preventDefault(); // Mencegah reload halaman

    btnSubmit.disabled = true;
    btnSubmit.textContent = "Memproses...";

    const formData = new FormData(form);

    const dataMahasiswa = Object.fromEntries(formData.entries());

    btnSubmit.disabled = false;
    btnSubmit.textContent = "Simpan";

    clearAllError();
    const validationError = validateMahasiswaForm(dataMahasiswa);

    if (Object.keys(validationError).length > 0) {
      // Perbaiki logika cek error
      displayFieldError(validationError);
      btnSubmit.disabled = false;
      btnSubmit.textContent = "Simpan";
      return;
    }

    btnSubmit.textContent = "Menyimpan...";

    const responsseErr = await createDataMhs(dataMahasiswa);
    if (responsseErr) {
      displayFieldError(responsseErr);
    }

    btnSubmit.textContent = "Berhasil";
    btnSubmit.disabled = true;
  });

  const displayFieldError = (error) => {
    if (error.nim) {
      errorNim.innerText = error.nim;
    }

    if (error.nama) {
      errorNama.innerText = error.nama;
    }

    if (error.id_prodi) {
      errorIdProdi.innerText = error.id_prodi;
    }

    if (error.email) {
      errorEmail.innerHTML = error.email;
    }
  };

  const clearAllError = () => {
    [...document.getElementsByClassName("error")].map((el) => {
      el.innerText = "";
    });
  };
});
