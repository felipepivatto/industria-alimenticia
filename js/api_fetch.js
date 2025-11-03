// api_fetch.js - versão corrigida usando Cat Facts API
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('suggestBtn');
  if (!btn) return;

  btn.onclick = () => {
    btn.disabled = true;
    btn.textContent = 'Buscando...';

    fetch('https://catfact.ninja/fact')
      .then(r => r.json())
      .then(d => {
        const desc = document.getElementById('descricao');
        desc.value = d.fact + ' (sugerido pela API)';
      })
      .catch(err => {
        alert('Erro ao buscar da API: ' + err);
      })
      .finally(() => {
        btn.disabled = false;
        btn.textContent = 'Sugerir descrição (API)';
      });
  };
});
