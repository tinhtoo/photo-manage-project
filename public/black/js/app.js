//delete
function delete_alert(e){
    if(!window.confirm('本当に削除しますか？')){
       return false;
    }
    document.deleteform.submit();
 };

// update
function update_alert(e){
if(!window.confirm('更新します。大丈夫でしょうか？')){
    return false;
}
document.updateform.submit();
};

// フォーム
// var hotelValid = {
//     //入力欄別にルールを作成
//     rules:{
//         name:{
//             required:true
//         },
//         email:{
//             required:true
//         },
//         subject:{
//             required:true,
//             maxlength:50,
//         },
//         message:{
//             required:true,
//             maxlength:500,
//         },
//     },
//     //messageを自分好みに設定
//     messages:{
//         name:{
//             required:"これは必須項目です！"
//         },
//         email:{
//             required:"これは必須項目です！"
//         },
//         subject:{
//             required:"これは必須項目です！"
//         },
//         message:{
//             required:"これは必須項目です！"
//         }
//     }
// }
