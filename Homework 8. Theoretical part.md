**Домашняя работа 8. Теоретическая часть**
1. Найти в проекте Front Controller и расписать классы, которые с ним взаимодействуют   
2. Найти в проекте Registry и объяснить, почему он был применён  
3. Рассказать, какой тип модели используется в проекте   
**Ответы:** 
1. Паттерн Front Controller находится в файле index.html (который находится в папке web) так как все запросы приходят в него. 
Он взаимодействует с классами ContainerBuilder (которая создает контейнер - используется vendor) и Kernel (в котором роутинг, загрузка конфигов и проч). Основная логика работы фреймфорка сосредоточена в классе Kernel (в который мы передаем запросы, а он их обрабатывает).  
2. Паттерн Registry ипользуется для работтой с объектом SessionInterface (session). Т.к. нам необходимо иметь доступ в нескольких местах проекта.  
3. В данном проекте используется Table Module, т.к. логика области определения разделена на отдельные классы для каждго массива с информацией, а объект не содержит информацию по каждой записи из массива (как говорится в паттерне Domain Model).  