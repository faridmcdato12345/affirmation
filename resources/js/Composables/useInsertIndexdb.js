export function useInsertIndexdb() {
  
  const insertData = async (userId) => {
    const request = indexedDB.open('user_info', 2)
    request.onupgradeneeded = (event) => {
      const db = event.target.result

      if(!db.objectStoreNames.contains('user')){
        db.createObjectStore('user', { keyPath: 'id',autoIncrement: false})
      }
    }
    request.onsuccess = (event) => {
      const db = event.target.result
      if (db.objectStoreNames.contains('user')) {
        const transaction = db.transaction('user', 'readwrite')
        const store = transaction.objectStore('user')
    
        const checkRequest = store.count()
    
        checkRequest.onsuccess = (event) => {
          const count = event.target.result
    
          if (count > 0) {
            // Update data if the table exists
            const updateRequest = store.get(1) // Replace with your key
    
            updateRequest.onsuccess = (event) => {
              const existingData = event.target.result
    
              if (existingData) {
                // Modify the existing data
                existingData.user_id = userId
    
                // Put the updated data back into the object store
                const putRequest = store.put(existingData)
    
                putRequest.onsuccess = () => {
                  console.log('Data updated successfully')
                }
    
                putRequest.onerror = (event) => {
                  console.error('Error updating data:', event.target.error)
                }
              } else {
                console.log('Data with key not found')
              }
            }
          } else {
            // Add data if the table doesn't exist
            const newData = { id: 1, user_id: userId }
    
            const addRequest = store.add(newData)
    
            addRequest.onsuccess = () => {
              console.log('Data added successfully')
            }
    
            addRequest.onerror = (event) => {
              console.error('Error adding data:', event.target.error)
            }
          }
        }
      } else {
        const transaction = db.transaction('user', 'readwrite')
        const store = transaction.objectStore('user')
        store.add({
          id: 1,
          user_id: userId
        })
      }
    }
    request.onerror = (event) => {
      console.error('Error opening database:', event.target.error)
    }
    // console.log('opendatabase db: ',db)
    // if (db) {
    //   const transaction = db.transaction('user', 'readwrite')
    //   const store = transaction.objectStore('user')
    //   //   store.add({
    //   //     id: 1,
    //   //     user_id: userId
    //   //   })
    //   const getRequest = store.get(1)
    //   getRequest.onsuccess = (event) => {
    //     const existingData = event.target.result

    //     if(existingData) {
    //       existingData.user_id = userId
    //       const putRequest = store.put(existingData)
                
    //       putRequest.onsuccess = () => {
    //         console.log('Data updated successfully')
    //       }
    //       putRequest.onerror = (event) => {
    //         console.error('Error updateing data: ', event.target.error)
    //       }
    //     } else {
    //       store.add({
    //         id: 1,
    //         user_id: userId
    //       })
    //     }
    //   }
    //   transaction.oncomplete = () => {
    //     console.log('userid inserted to indexdb')
    //   }
    // }
  }

  //   const openDatabase = async () => {
  //     return new Promise((resolve, reject) => {
  //       const request = indexedDB.open('user_info', 2)

  //       request.onsuccess = (event) => {
  //         const db = event.target.result
  //         resolve(db)
  //       }

  //       request.onerror = (event) => {
  //         console.log('Error opening database: ', event.target.error)
  //         reject()
  //       }

  //       request.onupgradeneeded = (event) => {
  //         const db = event.target.result

  //         if(!db.objectStoreNames.contains('user')){
  //           db.createObjectStore('user', { keyPath: 'id',autoIncrement: false})
  //         }
  //       }
  //     })
  //   }
  return { insertData }
}