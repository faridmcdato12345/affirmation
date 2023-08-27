export function useInsertIndexdb() {
  
  const insertData = async (userId) => {
    const db = await openDatabase()

    if (db) {
      const transaction = db.transaction('user', 'readwrite')
      const store = transaction.objectStore('user')
      store.add({
        id: 1,
        user_id: userId
      })
      transaction.oncomplete = () => {
        console.log('userid inserted to indexdb')
      }
    }
  }

  const openDatabase = async () => {
    return new Promise((resolve, reject) => {
      const request = indexedDB.open('user_info', 2)

      request.onsuccess = (event) => {
        const db = event.target.result
        resolve(db)
      }

      request.onerror = (event) => {
        console.log('Error opening database: ', event.target.error)
        reject()
      }

      request.onupgradeneeded = (event) => {
        const db = event.target.result

        if(!db.objectStoreNames.contains('user')){
          db.createObjectStore('user', { keyPath: 'user_id',autoIncrement: false})
        }
      }
    })
  }
  return { insertData }
}