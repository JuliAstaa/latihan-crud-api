import { getAllDataProdi } from "./api/prodiServices.js";
import {
  getDataMahasiswaById,
  updateDataMahasiswa,
} from "./api/mahasiswaServices.js";
import { validateMahasiswaFormToUpdate } from "./utils/validator.js";

// update data through api

const patchDataMahasiswa = async (dataMahasiswa) => {
  try {
    const apiResponse = await updateDataMahasiswa(dataMahasiswa);

    if (apiResponse.status === 200) {
      sessionStorage.setItem(
        "flashMessage",
        JSON.stringify({
          type: "success",
          text: apiResponse.message || "Data mahasiswa berhasil diupdate!",
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

document.addEventListener("DOMContentLoaded", () => {
  const prodiOpt = document.getElementById("id_prodi");

  // ambil id dari param
  const params = new URLSearchParams(window.location.search);
  const mahasiswaId = params.get("id");

  // ambil data prodi

  // ambil data prodi dan data mahasiswa
  const init = async () => {
    const [dataProdi, dataMhs] = await Promise.all([
      getAllDataProdi(),
      getDataMahasiswaById(mahasiswaId),
    ]);

    const listProdi = dataProdi.map((prodi) => {
      return `<option value="${prodi.id}">${prodi.kode_prodi}----${prodi.prodi}</option>`;
    });

    prodiOpt.innerHTML += listProdi;

    document.getElementById("nim").innerText = dataMhs.nim;
    document.getElementById("id_mhs").value = dataMhs.id;
    document.getElementById("nama").value = dataMhs.nama_mhs;
    document.getElementById("id_prodi").value = dataMhs.id_prodi;
    document.getElementById("email").value = dataMhs.email;
  };

  const form = document.getElementById("formTambahMahasiswa"); // PERBAIKI TYPO
  const btnSubmit = document.getElementById("submit");
  const errorNim = document.getElementById("error-nim");
  const errorNama = document.getElementById("error-nama");
  const errorIdProdi = document.getElementById("error-idProdi");
  const errorEmail = document.getElementById("error-email");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    btnSubmit.disabled = true;
    btnSubmit.textContent = "Memproses...";

    const formData = new FormData(form);

    const dataMahasiswa = Object.fromEntries(formData.entries());

    btnSubmit.disabled = false;
    btnSubmit.textContent = "Simpan";

    clearAllError();

    const validationError = validateMahasiswaFormToUpdate(dataMahasiswa);

    if (Object.keys(validationError) > 0) {
      displayFieldError(validationError);
      btnSubmit.disabled = false;
      btnSubmit.textContent = "Simpan";
    }

    const responseErr = await patchDataMahasiswa(dataMahasiswa);

    if (responseErr) {
      displayFieldError(responseErr);
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

  init();
});
