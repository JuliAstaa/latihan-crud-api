const isRequired = (value) => {
  return value.trim() !== "";
};

const hasMinLength = (value, min) => {
  return value.trim().length < min;
};

const hasMaxLength = (value, max) => {
  return value.trim().length > max;
};

const isNameValid = (value) => {
  const namePattern = /^[a-zA-Z -]+$/;
  return namePattern.test(value);
};

const isEmailValid = (value) => {
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailPattern.test(value);
};

const isNumeric = (value) => {
  const numerinPattern = /^\d+$/;
  return numerinPattern.test(value);
};

const validateMahasiswaForm = (data) => {
  const error = {};

  // validasi nama
  if (!isRequired(data.nama || "")) {
    error.nama = "Nama tidak boleh kosong";
  } else if (!isNameValid(data.nama)) {
    error.nama =
      "Nama tidak valid, nama hanya boleh menggunakan huruf, spasi, dan dash saja";
  }

  // validasi nim
  if (!isRequired(data.nim || "")) {
    error.nim = "NIM tidak boleh kosong";
  } else if (!isNumeric(data.nim)) {
    error.nim = "NIM hanya boleh menggunakan angka";
  } else if (hasMinLength(data.nim, 10)) {
    error.nim = "NIM minimal memiliki panjang 10 karakter";
  } else if (hasMaxLength(data.nim, 20)) {
    error.nim = "NIM maksimal memiliki panjang 20 karakter";
  }

  //validasi prodi
  if (!isRequired(data.id_prodi || "")) {
    error.idProdi = "ID prodi tidak boleh kosong";
  } else if (!isNumeric(data.id_prodi)) {
    error.idProdi = "ID prodi hanya boleh menggunakan angka";
  }

  if (!isRequired(data.email || "")) {
    error.email = "Email tidak boleh kosong";
  } else if (!isEmailValid(data.email)) {
    error.email = "Format email tidak valid";
  }

  return error;
};

export { validateMahasiswaForm };
