export function formatDate(dateString) {
  let date = new Date(dateString);

  let day = String(date.getDate()).padStart(2, '0');
  let month = String(date.getMonth() + 1).padStart(2, '0'); // Los meses van de 0 a 11
  let year = date.getFullYear();

  let hours = String(date.getHours()).padStart(2, '0');
  let minutes = String(date.getMinutes()).padStart(2, '0');

  return `${day}/${month}/${year} a las ${hours}:${minutes}hrs`;
};