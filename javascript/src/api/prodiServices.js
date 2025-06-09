const APIProdi = "http://localhost/latihan-crud-api/php/api/get-data-prodi.php";

const getAllDataProdi = async () => {
  const response = await fetch(APIProdi);
  const apiData = await response.json();
  return apiData.data;
};

export { getAllDataProdi };
