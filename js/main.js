console.log("it's working");

if(document.getElementById("createPostModal")){
  document.getElementById("createPostModal").addEventListener('click',function(){
    document.getElementById("createPostFrom").click();
  });
}