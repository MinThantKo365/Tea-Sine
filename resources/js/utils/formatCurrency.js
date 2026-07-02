export function formatCurrency(amount) {
  return `${Number(amount).toLocaleString('en-US', { maximumFractionDigits: 0 })} Ks`
}
