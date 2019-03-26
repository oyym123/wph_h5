<teamplate>
  <weui-distpicker
    :province="message.province"
    :city="message.city"
    :area="message.area"></weui-distpicker>
</template>

<script>
import WeuiDistpicker from 'weui-distpicker'

export default {
  components: { WeuiDistpicker },
  data() {
    return {
      message: {
        province: '广东省',
        city: '广州市',
        area: '海珠区'
      },
    }
  },
}
</script>