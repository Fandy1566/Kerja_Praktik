function initialise(populationSize, LessonSize, timespaceSize) {
    population = [];
    for (let ips = 0; ips < populationSize; ips++) {
        chromosome = [];
        while (chromosome.length < LessonSize) {
            var r = Math.floor(Math.random() * Math.floor(timespaceSize));
            if (chromosome.indexOf(r) === -1) chromosome.push(r);
        }
        population.push(chromosome);
    }

    return population;
}

//fitness for one chromosome
function fitness(chromosome) {
    // console.log(chromosome);
    score = 0;
    for (let i = 0; i < chromosome.length; i++) {
        if (chromosome[i] <= 35) {
            if (chromosome.includes(chromosome[i] + 35)) {
                if (lessons[i].teacher != lessons[chromosome.indexOf(chromosome[i] + 35)].teacher) {
                    score++;
                }
            }
            else { score += 2; }
        }
        else {
            if (chromosome.includes(chromosome[i] - 35)) {
                if (lessons[i].teacher != lessons[chromosome.indexOf(chromosome[i] - 35)].teacher) {
                    score++;
                }
            }
            else { score += 2; }
        }
        //check if 2 hours course can be delivered
        if ((chromosome[i] % 7 != 2 && chromosome[i] % 7 != 6 && !chromosome.includes(chromosome[i] + 1)) || lessons[i].duration === 1) {
            score++;
        }
    }
    return score / (5 * chromosome.length);
}

function selectParents(population) {
    let sum = 0;
    population.forEach(e => { sum += e.fitness; });

    let p1 = Math.floor(Math.random() * Math.floor(sum));
    let i = 0;
    while (p1 < sum) {
        p1 += population[i].fitness;
        i++;
    }
    i--;
    let p2 = Math.floor(Math.random() * Math.floor(sum));
    let j = 0;
    while (p2 < sum) {
        p2 += population[j].fitness;
        j++;
    }
    j--;
    return { mother: population[i], father: population[j] };
}

// One point crossover
//l is length of chromosome,number of genes
//n is number of timespace slot
function crossover(chromosome1, chromosome2, l, n) {
    p = Math.floor(Math.random() * Math.floor(l-1));
    child1 = chromosome1.slice(0,p+1) + "," + chromosome2.slice(p+1, l);
    child2 = chromosome2.slice(0,p+1) + "," + chromosome1.slice(p+1, l);
    child1 = child1.split(",").map(x => +x);
    child2 = child2.split(",").map(x => +x);
    let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index)
    duplicates1 = findDuplicates(child1);
    while (duplicates1.length > 0) {
        g = Math.floor(Math.random() * Math.floor(n));
        child1[child1.indexOf(duplicates1[0])] = g;
        duplicates1 = findDuplicates(child1);
    }
    duplicates2 = findDuplicates(child2);
    while (duplicates2.length > 0) {
        g = Math.floor(Math.random() * Math.floor(n));
        child2[child2.indexOf(duplicates2[0])] = g;
        duplicates2 = findDuplicates(child2);
    }
    return { child1: child1, child2: child2 };
}

//swap mutation of two random genes
function mutation(chromosome, l) {
    p1 = Math.floor(Math.random() * Math.floor(l));
    p2 = Math.floor(Math.random() * Math.floor(l));
    [chromosome[p1], chromosome[p2]] = [chromosome[p2], chromosome[p1]];
    //return chromosome;
}


//l = chromosome length
//n = timespace slot number
//s = population size
function evolve(population, l, n, s, pc, pm) {
    population.sort(function (a, b) {
        return b.fitness - a.fitness;
    });
    parents = selectParents(population);
    if (Math.random() <= pc) {
        children = crossover(parents.mother.chromosome, parents.father.chromosome, l, n);
    }
    else {
        children = {
            child1: parents.mother.chromosome,
            child2: parents.father.chromosome
        }
    }
    if(Math.random() <= pm){
        mutation(children.child1, l);
    }
    if(Math.random() <= pm){
        mutation(children.child2, l);
    }
    population[s-1] = {chromosome:children.child1, fitness: fitness(children.child1)};
    population[s-2] = {chromosome:children.child2, fitness: fitness(children.child2)};
}