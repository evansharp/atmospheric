//re-organize data for chart.js

temp_obj = {
  labels: [], //time
  datasets: [
              {
                data: [], //val
                label: "Temperature (C)",
                borderColor: "#c45850",
                fill: true
              }
            ]
          };
hum_obj = {
  labels: [], //time
  datasets: [
              {
                data: [], //val
                label: "Humidity (%RH)",
                borderColor: "#3cba9f",
                fill: false
              }
            ]
          };
press_obj = {
  labels: [], //time
  datasets: [
              {
                data: [], //val
                label: "Pressure (mm/Hg)",
                borderColor: "#3e95cd",
                fill: false
              }
           ]
};

var temp_opt = {
            title:{
              display: true,
              text: "The Last Hour of Temperature"
            },
            scales: {
                xAxes: [
                    {
                      ticks: {
                        callback: function(tickvalue, index, ticks){
                          return moment.unix(tickvalue).format("h:mm:ss a");
                        }
                      }
                    }
                ]
            }
          };
var hum_opt = {
            title:{
              display: true,
              text: "The Last Hour of Humidity"
            },

          scales: {
              xAxes: [
                  {
                    ticks: {
                      callback: function(tickvalue, index, ticks){
                        return moment.unix(tickvalue).format("h:mm:ss a");
                      }
                    }
                  }
              ]
          }
        };

var press_opt = {
            title:{
              display: true,
              text: "The Last Hour of Pressue"
            },
          scales: {
              xAxes: [
                  {
                    ticks: {
                      callback: function(tickvalue, index, ticks){
                        return moment.unix(tickvalue).format("h:mm:ss a");
                      }
                    }
                  }
              ]
          }
        };

//loop the db data and push it into the prototype chart js data object
for(var rec=0; rec<data.length; rec++){
  var ts = data[rec]['ts'];
  var tempval = data[rec]['temp_value'];
  var humval = data[rec]['hum_value'];
  var pressval = data[rec]['press_value'];

  temp_obj.labels.push(ts);
  hum_obj.labels.push(ts);
  press_obj.labels.push(ts);

  temp_obj.datasets[0].data.push(tempval);
  hum_obj.datasets[0].data.push(humval);
  press_obj.datasets[0].data.push(pressval);
}

console.log(temp_obj, hum_obj, press_obj);

new Chart(document.getElementById("temp_chart"), {type: "line", data: temp_obj, options: temp_opt});
new Chart(document.getElementById("hum_chart"), {type: "line", data: hum_obj, options: hum_opt});
new Chart(document.getElementById("press_chart"), {type: "line", data: press_obj, options: press_opt});
