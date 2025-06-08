const API = "http://localhost/latihan-crud-api/php/api/";

// get all data mahasiswa
const getAllDataMahasiswa = async () => {
  const response = await fetch(`${API}get-data.php`);
  if (!response) throw new error("Gagal mendapatkan data!");
  const apiData = await response.json();
  return apiData.data;
};

export { getAllDataMahasiswa };
