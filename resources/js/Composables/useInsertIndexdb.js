export function useInsertIndexdb() {
  
  const insertData = async (userId) => {
    const request = indexedDB.open('user_info', 3)
    request.onupgradeneeded = (event) => {
      const db = event.target.result

      if(!db.objectStoreNames.contains('user')){
        db.createObjectStore('user', { keyPath: 'id',autoIncrement: false})
        console.log('onupgraded')
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
      }
    }
    request.onerror = (event) => {
      console.error('Error opening database:', event.target.error)
    }
  }
  return { insertData }
}