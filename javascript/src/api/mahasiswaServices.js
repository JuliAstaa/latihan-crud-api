const API = "http://localhost/latihan-crud-api/php/api";

// get all data mahasiswa
const getAllDataMahasiswa = async () => {
  const response = await fetch(`${API}/get-data.php`);
  if (!response) throw new error("Gagal mendapatkan data!");
  const apiData = await response.json();
  return apiData.data;
};

//get data mahasiswa by id
const getDataMahasiswaById = async (id) => {
  const response = await fetch(`${API}/get-data.php?id=${id}`);
  if (!response) throw new error("Gagal mendapatkan data!");
  const apiData = await response.json();
  return apiData.data;
};

// create data mahasiswa
const createDataMahasiswa = async (dataMahasiswa) => {
  const response = await fetch(`${API}/create-data.php`, {
    method: "POST",
    header: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(dataMahasiswa),
  });

  return response.json();
};

// update data mahasiswa (patch)
const updateDataMahasiswa = async (dataMahasiswa) => {
  const response = await fetch(`${API}/update-data.php`, {
    method: "PATCH",
    header: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(dataMahasiswa),
  });

  return response.json();
};

const deleteDataMahasiswa = async (idMahasiswa) => {
  const response = await fetch(`${API}/delete-data.php?id=${idMahasiswa}`, {
    method: "DELETE",
    header: {
      "Content-Type": "application/json",
    },
  });
  return response.json();
};

export {
  getAllDataMahasiswa,
  createDataMahasiswa,
  updateDataMahasiswa,
  deleteDataMahasiswa,
  getDataMahasiswaById,
};
