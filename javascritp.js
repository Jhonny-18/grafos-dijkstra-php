document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const resultContainer = document.createElement("div");
    resultContainer.classList.add("result");
    document.body.appendChild(resultContainer);
  
    form.addEventListener("submit", async function(event) {
      event.preventDefault();
  
      const homeLocal = form.homeLocal.value;
      const destination = form.destination.value;
  
      if (homeLocal === destination) {
        resultContainer.innerHTML = "O local de partida e o destino são iguais!";
        resultContainer.style.color = "red";
        return;
      }
  
      try {
        const response = await fetch(`seuscript.php?homeLocal=${homeLocal}&destination=${destination}`);
        const text = await response.text();
  
        resultContainer.innerHTML = `<strong>Resultado:</strong><br>${text.replace(/\n/g, "<br>")}`;
        resultContainer.style.color = "#00796b";
      } catch (error) {
        resultContainer.innerHTML = "Erro ao buscar o caminho. Tente novamente.";
        resultContainer.style.color = "red";
      }
    });
  });
  