import {Line} from 'vue-chartjs';
export default {
  extends: Line,
  props: ['labels', 'data', 'options'],
  mounted() {
    this.renderChart({
      labels: this.labels,
      datasets: this.data
    }, this.options)
  }
}