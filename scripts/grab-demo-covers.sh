#!/bin/zsh
# Grabs homepage screenshots for the store's demo covers.
#
# TEMPORARY DEMO MATERIAL. These are other people's websites — they are here only so
# the store can be reviewed with realistic content, they are gitignored, and they must
# be replaced with your own screenshots before production.
#
# The seeder prefers anything in template-cover/ over its own drawn mocks, so deleting
# this folder reverts the store to generated artwork. Filenames are
# <category-canonical>-<n>.png and are handed out in order within each shelf.
#
#   ./scripts/grab-demo-covers.sh
#   php artisan demo:content        # re-point the products at whatever is present

cd "$(dirname "$0")/.."
OUT=public/userfiles/image/template-cover
mkdir -p "$OUT"

shoot() {  # shoot <name> <url>
  local out="$OUT/$1.png"
  [ -s "$out" ] && { echo "  skip  $1"; return; }
  curl -s -m 90 -L -o "$out" "https://image.thum.io/get/width/1400/crop/875/noWait/$2"
  local sz=$(stat -f%z "$out" 2>/dev/null || echo 0)
  # Blocked sites answer with a small denial page rather than a screenshot.
  if [ "$sz" -lt 60000 ]; then
    rm -f "$out"; echo "  FAIL  $1  (site blocked the capture)"
  else
    echo "  ok    $1  $((sz/1024))KB"
  fi
}


# website-ban-hang
shoot website-ban-hang-1 https://www.patagonia.com
shoot website-ban-hang-2 https://www.shopify.com
shoot website-ban-hang-3 https://www.apple.com/shop
shoot website-ban-hang-4 https://www.gymshark.com
shoot website-ban-hang-5 https://www.thegioididong.com
shoot website-ban-hang-6 https://www.uniqlo.com/vn/vi/

# website-doanh-nghiep
shoot website-doanh-nghiep-1 https://stripe.com
shoot website-doanh-nghiep-2 https://www.ibm.com
shoot website-doanh-nghiep-3 https://www.atlassian.com
shoot website-doanh-nghiep-4 https://www.fpt.com.vn
shoot website-doanh-nghiep-5 https://www.viettel.vn
shoot website-doanh-nghiep-6 https://www.masangroup.com

# landing-page
shoot landing-page-1 https://www.superhuman.com
shoot landing-page-2 https://framer.com
shoot landing-page-3 https://tailwindcss.com
shoot landing-page-4 https://www.notion.com
shoot landing-page-5 https://www.figma.com
shoot landing-page-6 https://slack.com

# website-bat-dong-san
shoot website-bat-dong-san-1 https://batdongsan.com.vn
shoot website-bat-dong-san-2 https://www.airbnb.com
shoot website-bat-dong-san-3 https://www.redfin.com
shoot website-bat-dong-san-4 https://nhatot.com
shoot website-bat-dong-san-5 https://www.booking.com
shoot website-bat-dong-san-6 https://homedy.com

# giao-duc
shoot giao-duc-1 https://www.coursera.org
shoot giao-duc-2 https://www.khanacademy.org
shoot giao-duc-3 https://hocmai.vn
shoot giao-duc-4 https://www.codecademy.com
shoot giao-duc-5 https://www.edx.org
shoot giao-duc-6 https://vietjack.com

# mau-quan-tri
shoot mau-quan-tri-1 https://demo.themeselection.com/vuexy-vuejs-admin-template/demo-1/dashboards/analytics
shoot mau-quan-tri-2 https://tabler.io
shoot mau-quan-tri-3 https://demos.creative-tim.com/material-dashboard/pages/dashboard.html
shoot mau-quan-tri-4 https://coreui.io
shoot mau-quan-tri-5 https://demo.themeselection.com/materio-mui-react-nextjs-admin-template/landing
shoot mau-quan-tri-6 https://www.tremor.so

echo
echo "cover: $(ls -1 $OUT | wc -l | tr -d " ") file, $(du -sh $OUT | cut -f1)"
