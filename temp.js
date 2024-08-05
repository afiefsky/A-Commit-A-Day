let voucher_new_user_prefix = cst.voucher_new_user_prefix_id
if (country_id != cst.country_id_default) {
    voucher_new_user_prefix = cst.voucher_new_user_prefix_sg
}

let voucher_list_where = " AND user_id = ? AND vc_code LIKE ? "
let voucherListData = [user_id, voucher_new_user_prefix + "%"]
let voucher_list_sortby = " vc.vc_id DESC "
let voucherList = await req.model('promo').getAllVoucherWithPromoByVcCode(voucher_list_where, voucherListData, voucher_list_sortby, 0, lang)

let nonDeliveryVoucherList = []
let deliveryVoucherList = []

if (country_id == cst.country_id_default) {
    nonDeliveryVoucherList = voucherList.filter(voucher => !voucher.vc_code.includes('DEL'))
    deliveryVoucherList = voucherList.filter(voucher => voucher.vc_code.includes('DEL'))
}

let non_delivery_prm_icon = nonDeliveryVoucherList[0].prm_icon ? nonDeliveryVoucherList[0].prm_icon : ""
let delivery_prm_icon = deliveryVoucherList[0].prm_icon ? deliveryVoucherList[0].prm_icon : ""

let finalVoucherList = [
    { // non delivery voucher
        "voucher_name": nonDeliveryVoucherList[0].prm_short_name,
        "voucher_desc": nonDeliveryVoucherList[0].prm_short_description,
        "voucher_qty": nonDeliveryVoucherList.length,
        "voucher_icon": non_delivery_prm_icon
    }
]

if (country_id == cst.country_id_default) {
    finalVoucherList.push(
        { // delivery voucher
            "voucher_name": deliveryVoucherList[0].prm_short_name,
            "voucher_desc": deliveryVoucherList[0].prm_short_description,
            "voucher_qty": deliveryVoucherList.length,
            "voucher_icon": delivery_prm_icon
        }
    )
}