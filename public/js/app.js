document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-open-modal]').forEach(btn => {
    btn.addEventListener('click', () => {
      const modal = document.getElementById(btn.getAttribute('data-open-modal'));
      if (modal) modal.classList.add('active');
    });
  });

  document.querySelectorAll('[data-close-modal]').forEach(btn => {
    btn.addEventListener('click', () => {
      const modal = document.getElementById(btn.getAttribute('data-close-modal'));
      if (modal) modal.classList.remove('active');
    });
  });

  document.querySelectorAll('.confirm-delete').forEach(link => {
    link.addEventListener('click', (e) => {
      if (!confirm('Confirmer la suppression ?')) e.preventDefault();
    });
  });

  const addProductBtn = document.getElementById('add-product');
  const produitItems = document.getElementById('produit-items');
  if (addProductBtn && produitItems) {
    let index = 1;
    addProductBtn.addEventListener('click', () => {
      const div = document.createElement('div');
      div.className = 'product-row';
      div.innerHTML = `<select name="produits[${index}][id]">${Array.from(document.querySelectorAll('#produit-items select option')).map(option => `<option value="${option.value}" data-price="${option.getAttribute('data-price')}">${option.text}</option>`).join('')}</select><input type="number" name="produits[${index}][quantite]" value="1" min="1">`;
      produitItems.appendChild(div);
      index++;
    });
  }

  const amountInput = document.getElementById('montant_total');
  const totalAmount = document.getElementById('total-amount');
  if (amountInput && totalAmount) {
    const updateTotal = () => {
      let total = 0;
      document.querySelectorAll('#produit-items .product-row').forEach(row => {
        const select = row.querySelector('select');
        const qtyInput = row.querySelector('input[type="number"]');
        const price = select?.selectedOptions[0]?.getAttribute('data-price') || 0;
        total += parseFloat(price) * parseInt(qtyInput?.value || '1', 10);
      });
      amountInput.value = total;
      totalAmount.textContent = total.toLocaleString('fr-FR');
    };
    document.addEventListener('change', (e) => {
      if (e.target.matches('#produit-items select, #produit-items input')) updateTotal();
    });
    updateTotal();
  }
});
