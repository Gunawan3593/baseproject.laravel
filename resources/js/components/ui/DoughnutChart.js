import {Doughnut}  from 'vue-chartjs';
export default {
  extends: Doughnut,
  props: ['labels', 'data', 'options'],
  mounted() {
    this.renderChart({
      labels: this.labels,
      datasets: this.data
    }, this.options)
  }
}