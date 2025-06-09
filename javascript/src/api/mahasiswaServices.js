const API = "http://localhost/latihan-crud-api/php/api/";

// get all data mahasiswa
const getAllDataMahasiswa = async () => {
  const response = await fetch(`${API}get-data.php`);
  if (!response) throw new error("Gagal mendapatkan data!");
  const apiData = await response.json();
  return apiData.data;
};

// create data mahasiswa
const createDataMahasiswa = async (dataMahasiswa) => {
  const response = await fetch(`${API}create-data.php`, {
    method: "POST",
    header: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(dataMahasiswa),
  });

  return response.json();
};

// update data mahasiswa (patch)
const updateDataMahasiswa = async (dataMahasiswa) => {};

const deleteDataMahasiswa = async (idMahasiswa) => {};

export {
  getAllDataMahasiswa,
  createDataMahasiswa,
  updateDataMahasiswa,
  deleteDataMahasiswa,
};
